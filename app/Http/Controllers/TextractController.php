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
    
          // Combine all words into a full string
    $text = '';
    foreach ($result->get('Blocks') as $block) {
        if ($block['BlockType'] === 'WORD') {
            $text .= $block['Text'] . ' ';
        }
    }

    // Step 1: Extract name (if pattern matches)
    $studentName = null;
    if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+?)\s+(SHRI|SUSHRI|WHOSE)/i', $text, $nameMatches)) {
        $studentName = trim($nameMatches[1]);
    }

    // Step 2: Extract all potential subject + marks rows (flexible)
    $subjects = [];
 // This regex tries to find lines like:
    // SUBJECT_NAME 100 33 061 061  or SUBJECT_NAME 75 25 050 015 etc.
    preg_match_all('/([A-Z&\[\]\/\s\.]+?)\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})/', $text, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $subjectName = trim($match[1]);

        // Skip junk subjects
        if (strlen($subjectName) < 3 || str_word_count($subjectName) < 1) {
            continue;
        }

        $subjects[] = [
            'subject' => $subjectName,
            'max_marks_theory' => $match[2],
            'min_marks_theory' => $match[3],
            'obtained_theory' => $match[4],
            'obtained_practical' => $match[5],
        ];
    }

    return response()->json([
        'name' => $studentName,
        'subjects' => $subjects,
        'raw_text' => $text, // optional: remove in production
    ]);

    } catch (\Aws\Textract\Exception\TextractException $e) {
        return response()->json([
            'error' => $e->getAwsErrorMessage() ?? $e->getMessage()
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
}
