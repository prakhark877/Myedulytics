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
            
            // Combine all detected words into a string
            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] === 'WORD') {
                    $text .= $block['Text'] . ' ';
                }
            }
            
            // Extract student name (between 'CERTIFIED THAT' and 'SHRI' or similar)
            $studentName = null;
            if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+?)\s+(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $nameMatches)) {
                $studentName = trim($nameMatches[1]);
            }
            
            // Now extract subjects
            $subjects = [];
            
            // Break the text into chunks using keywords like subject names or numbers
            preg_match_all('/([A-Z&\[\]\/\.\s]{3,})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})/', $text, $matches, PREG_SET_ORDER);
            
            foreach ($matches as $match) {
                $subject = trim($match[1]);
            
                // Avoid junk like GRAND TOTAL or headings
                if (
                    stripos($subject, 'GRAND') !== false ||
                    stripos($subject, 'TOTAL') !== false ||
                    stripos($subject, 'GRADE') !== false ||
                    stripos($subject, 'MAX') !== false ||
                    stripos($subject, 'MIN') !== false
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
