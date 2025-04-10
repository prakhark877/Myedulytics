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

        // Step 3: Detect text
    $result = $textract->detectDocumentText([
        'Document' => [
            'Bytes' => $imageContent,
        ]
    ]);

    $text = '';
    foreach ($result->get('Blocks') as $block) {
        if ($block['BlockType'] === 'WORD') {
            $text .= $block['Text'] . ' ';
        }
    }

    $text = trim($text);

    // Step 4: Extract Name
    preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\s+SHRI|SUSHRI/i', $text, $nameMatch);
    $name = isset($nameMatch[1]) ? trim($nameMatch[1]) : null;

    // Step 5: Extract Subjects & Marks
    preg_match_all('/([A-Z\[\]\&\.\s]+)\s+(\d{3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})/', $text, $matches, PREG_SET_ORDER);

    $subjects = [];
    foreach ($matches as $match) {
        $subjectRaw = trim($match[1]);

        // Skip known non-subject lines
        if (preg_match('/^(MAX|MIN|REMARKS|TOTAL|GRAND|SUBJECTS?)/i', $subjectRaw)) {
            continue;
        }

        // Skip board name junk or lines with only capital letters and no real subject
        if (preg_match('/^[A-Z]{15,}$/', str_replace(' ', '', $subjectRaw))) {
            continue;
        }

        // Skip if not enough words (likely junk)
        if (str_word_count($subjectRaw) < 1) {
            continue;
        }

        $subjectClean = preg_replace('/[^A-Z0-9\[\]\&\/\.\s]/i', '', $subjectRaw);
        $subjectClean = trim(preg_replace('/\s+/', ' ', $subjectClean));

        $subjects[] = [
            'subject' => $subjectClean,
            'max_marks_theory' => $match[2],
            'min_marks_theory' => $match[3],
            'obtained_theory' => $match[4],
            'obtained_practical' => $match[5],
        ];
    }

    // Step 6: Return response
    return response()->json([
        'name' => $name,
        'subjects' => $subjects,
        'raw_text' => $text,
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
