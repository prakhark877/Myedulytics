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
             // Call Textract
    $result = $textract->detectDocumentText([
        'Document' => [
            'Bytes' => $imageContent,
        ]
    ]);

            // Read full text line-by-line
    $text = '';
    $lines = [];

    foreach ($result->get('Blocks') as $block) {
        if ($block['BlockType'] === 'LINE') {
            $lines[] = $block['Text'];
            $text .= $block['Text'] . "\n";
        }
    }

    // Extract student name
    $studentName = null;
    if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+?)\s+(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $nameMatches)) {
        $studentName = trim($nameMatches[1]);
    }

    // Extract subjects
    $subjects = [];

    foreach ($lines as $line) {
        if (preg_match('/^([A-Z&\[\]\.\s\/]+)\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})$/', trim($line), $match)) {
            $subject = trim($match[1]);

            // Filter out non-subject lines
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
