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
            
            // Extract student name
            $studentName = null;
            if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\n(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $matches)) {
                $studentName = trim($matches[1]);
            } elseif (preg_match('/\n([A-Z]{3,}\s+[A-Z]{3,})\n(SHRI|SUSHRI)/', $text, $fallback)) {
                $studentName = trim($fallback[1]);
            }
            
            // Extract subjects and marks
            $subjects = [];
            $lines = explode("\n", $text);
            $totalLines = count($lines);
            
            for ($i = 0; $i < $totalLines - 4; $i++) {
                $line = trim($lines[$i]);
            
                // Check if subject name line followed by pattern like: 100, 33, marks, marks
                if (preg_match('/^[A-Z &\[\]\/\.\+]{3,}$/', $line)) {
                    if (
                        isset($lines[$i + 1], $lines[$i + 2], $lines[$i + 3], $lines[$i + 4]) &&
                        is_numeric(trim($lines[$i + 1])) &&
                        is_numeric(trim($lines[$i + 2])) &&
                        is_numeric(trim($lines[$i + 3])) &&
                        is_numeric(trim($lines[$i + 4]))
                    ) {
                        $subjectName = $line;
                        $maxMarksTheory = trim($lines[$i + 1]);
                        $minMarksTheory = trim($lines[$i + 2]);
                        $obtainedTheory = trim($lines[$i + 3]);
                        $obtainedPractical = trim($lines[$i + 4]);
            
                        // Filter out totals, etc.
                        if (
                            stripos($subjectName, 'GRAND') === false &&
                            stripos($subjectName, 'TOTAL') === false &&
                            stripos($subjectName, 'GRADE') === false &&
                            stripos($subjectName, 'RESULT') === false
                        ) {
                            $subjects[] = [
                                'subject' => $subjectName,
                                'max_marks_theory' => $maxMarksTheory,
                                'min_marks_theory' => $minMarksTheory,
                                'obtained_theory' => $obtainedTheory,
                                'obtained_practical' => $obtainedPractical,
                            ];
                        }
                    }
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
