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
            
            // Combine all detected words into a single string
            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] === 'WORD') {
                    $text .= $block['Text'] . ' ';
                }
            }
            
            // Extract student name using a flexible regex
            $studentName = null;
            if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+?)\s+(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $nameMatches)) {
                $studentName = trim($nameMatches[1]);
            }
            
            // Prepare for extracting subjects
            $subjects = [];
            
            // Ignore known headers or remarks
            $ignorePhrases = [
                'MAX. MIN.', 'REMARKS', 'MARKS THEORY', 'TOTAL', 'GRAND TOTAL', 'GRADE', 'VALIDATOR'
            ];
            
            // Use basic whitespace-based "line" extraction (even if not true lines)
            $possibleLines = preg_split('/\s{2,}/', $text);
            
            foreach ($possibleLines as $line) {
                $line = trim($line);
            
                // Skip junk headers or known keywords
                $skip = false;
                foreach ($ignorePhrases as $phrase) {
                    if (stripos($line, $phrase) !== false) {
                        $skip = true;
                        break;
                    }
                }
                if ($skip) continue;
            
                // Try extracting actual subject + marks
                if (preg_match('/([A-Z&\[\]\/\.\s]{3,})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})/', $line, $match)) {
                    $subjectName = trim($match[1]);
            
                    // Basic filters
                    if (strlen($subjectName) > 2 && str_word_count($subjectName) >= 1) {
                        $subjects[] = [
                            'subject' => $subjectName,
                            'max_marks_theory' => $match[2],
                            'min_marks_theory' => $match[3],
                            'obtained_theory' => $match[4],
                            'obtained_practical' => $match[5],
                        ];
                    }
                }
            }
            
            // Final Response
            return response()->json([
                'name' => $studentName,
                'subjects' => $subjects,
                'raw_text' => $text, // optional: remove in production
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
