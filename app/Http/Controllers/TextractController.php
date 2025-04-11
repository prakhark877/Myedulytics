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
            
            // Combine LINE blocks instead of WORD for better context
            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] === 'LINE') {
                    $text .= $block['Text'] . "\n";
                }
            }
            
            // Extract student name - use better pattern
            $studentName = null;
            if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\n(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $matches)) {
                $studentName = trim($matches[1]);
            } else {
                // Try fallback if the main pattern fails
                if (preg_match('/\n([A-Z]{3,}\s+[A-Z]{3,})\n(SHRI|SUSHRI)/', $text, $fallback)) {
                    $studentName = trim($fallback[1]);
                }
            }
            
            // Extract subjects and marks
            $subjects = [];
            
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                if (preg_match('/^([A-Z &\[\]\/\.\+]{3,})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})$/', trim($line), $match)) {
                    $subject = trim($match[1]);
            
                    // Skip totals or unwanted lines
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
