<?php
namespace App\Http\Controllers;

use Aws\Textract\TextractClient;
use Illuminate\Http\Request;

class TextractController extends Controller
{
    public function extractText(Request $request)
    {

        $imageUrl = $request->input('url'); // CloudFront or S3 public URL

        // return $imageUrl;
        $textract = new TextractClient([
            'version' => 'latest',
            'region'  => 'ap-south-1', // e.g., us-west-2
                                       // No 'credentials' key needed — SDK will use IAM role or env vars
        ]);

        try {
            $imageContent = file_get_contents($imageUrl);

            if (!$imageContent) {
                throw new \Exception("Unable to download image from URL.");
            }
            
            $result = $textract->detectDocumentText([
                'Document' => [
                    'Bytes' => $imageContent,
                ]
            ]);
            
            // Combine LINE blocks
            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] === 'LINE') {
                    $text .= $block['Text'] . "\n";
                }
            }
            
            // Normalize text
            $text = preg_replace('/ +/', ' ', $text); // remove extra spaces
            $text = trim($text);
            
            // === Extract Name === //
            $studentName = null;
            if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\n(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $matches)) {
                $studentName = trim($matches[1]);
            } elseif (preg_match('/\n([A-Z]{3,}\s+[A-Z]{3,})\n(SHRI|SUSHRI)/', $text, $fallback)) {
                $studentName = trim($fallback[1]);
            } else {
                // Extra fallback: find a name-like line
                foreach (explode("\n", $text) as $line) {
                    if (preg_match('/^[A-Z]{3,}\s+[A-Z]{3,}$/', trim($line))) {
                        $studentName = trim($line);
                        break;
                    }
                }
            }
            
            // === Extract Subjects === //
            $subjects = [];
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                $line = trim($line);
            
                // Match lines with subject + 4 numbers (max, min, theory, practical)
                if (preg_match('/^([A-Z &\[\]\/\.\+\-]+)\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})$/', $line, $match)) {
                    $subject = trim($match[1]);
            
                    // Skip unwanted rows
                    if (
                        stripos($subject, 'GRAND') !== false ||
                        stripos($subject, 'TOTAL') !== false ||
                        stripos($subject, 'GRADE') !== false ||
                        stripos($subject, 'RESULT') !== false
                    ) {
                        continue;
                    }
            
                    $subjects[] = [
                        'subject' => $subject,
                        'max_marks_theory' => $match[2],
                        'min_marks_theory' => $match[3],
                        'obtained_theory' => $match[4],
                        'obtained_practical' => $match[5],
                    ];
                }
            }
            
            return response()->json([
                'name' => $studentName,
                'name11' => $studentName,
                'subjects' => $subjects,
                'raw_text' => $text,
            ]);
            
            
        } catch (\Aws\Textract\Exception\TextractException $e) {
            return response()->json([
                'error' => $e->getAwsErrorMessage() ?? $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
