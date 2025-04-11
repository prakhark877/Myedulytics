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
            
            // Combine LINE blocks
$text = '';
foreach ($result->get('Blocks') as $block) {
    if ($block['BlockType'] === 'LINE') {
        $text .= $block['Text'] . "\n";
    }
}

// Normalize and clean text
$text = preg_replace('/ +/', ' ', $text); // remove extra spaces
$text = preg_replace('/[^A-Za-z0-9\[\]\&\+\/\.\-\s\n]/', '', $text); // clean junk chars
$text = trim($text);

// === Extract Student Name === //
$studentName = null;
$lines = explode("\n", $text);
foreach ($lines as $index => $line) {
    $line = trim($line);
    if (stripos($line, 'CERTIFIED THAT') !== false && isset($lines[$index + 1])) {
        $nextLine = trim($lines[$index + 1]);
        if (isset($lines[$index + 2])) {
            $secondLine = trim($lines[$index + 2]);
            // check for uppercase name pattern
            if (preg_match('/^[A-Z\s]{5,}$/', $nextLine) && preg_match('/^(SHRI|SUSHRI)/i', $secondLine)) {
                $studentName = $nextLine;
                break;
            }
        }
    }
}

// Fallback to all-uppercase line before "SHRI" or "FATHER'S"
if (!$studentName) {
    foreach ($lines as $i => $line) {
        if (preg_match('/^(SHRI|SUSHRI|WHOSE|FATHER)/i', $line) && isset($lines[$i - 1])) {
            $prev = trim($lines[$i - 1]);
            if (preg_match('/^[A-Z\s]{5,}$/', $prev)) {
                $studentName = $prev;
                break;
            }
        }
    }
}

// Clean name extra line if contains '\n'
$studentName = preg_replace('/\s+/', ' ', $studentName);

// === Extract Subjects === //
$subjects = [];
foreach ($lines as $line) {
    $line = trim($line);

    // Match subject lines with pattern: SUBJECT_NAME then four numbers (Max, Min, Obtained Theory, Obtained Practical)
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
