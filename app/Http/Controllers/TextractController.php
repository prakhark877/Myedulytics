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

// Step 1: Detect text using AWS Textract
$result = $textract->detectDocumentText([
    'Document' => [
        'Bytes' => $imageContent,
    ]
]);

// Step 2: Combine all blocks into one string
$text = '';
foreach ($result->get('Blocks') as $block) {
    if ($block['BlockType'] === 'WORD') {
        $text .= $block['Text'] . ' ';
    }
}

// Step 3: Try to extract student name (more flexible)
$studentName = null;
if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+?)(?:\s+SHRI|\s+SUSHRI|\s+WHOSE|,)/i', $text, $nameMatches)) {
    $studentName = trim($nameMatches[1]);
}

// Step 4: Try extracting subjects line-by-line (for better accuracy)
$subjects = [];
$lines = explode("\n", $text); // if not line-separated, fallback:
if (count($lines) < 2) {
    $lines = preg_split('/(?<=\d{2,3})\s+(?=[A-Z])/', $text);
}

foreach ($lines as $line) {
    if (preg_match('/([A-Z&\[\]\/\s\.]+?)\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})/', $line, $match)) {
        $subjectName = trim($match[1]);

        // Skip very short or invalid subjects
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
}

// Final Response
return response()->json([
    'name' => $studentName,
    'subjects' => $subjects,
    'raw_text' => $text // optional: remove this in production
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
