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

$result = $textract->analyzeDocument([
    'Document' => [
        'Bytes' => $imageContent,
    ],
    'FeatureTypes' => ['TABLES', 'FORMS'],
]);

$blocks = $result->get('Blocks');
$blockMap = [];
$tables = [];

foreach ($blocks as $block) {
    $blockMap[$block['Id']] = $block;
}

// Group table data
foreach ($blocks as $block) {
    if ($block['BlockType'] === 'TABLE') {
        $tables[] = self::getTable($block, $blockMap);
    }
}

// Extract student name from all detected lines
$text = '';
foreach ($blocks as $block) {
    if ($block['BlockType'] === 'LINE') {
        $text .= $block['Text'] . "\n";
    }
}

$studentName = null;
if (preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\n(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $text, $matches)) {
    $studentName = trim($matches[1]);
} elseif (preg_match('/\n([A-Z]{3,}\s+[A-Z]{3,})\n(SHRI|SUSHRI)/', $text, $fallback)) {
    $studentName = trim($fallback[1]);
}

// Convert table into structured subjects
$subjects = [];
foreach ($tables as $table) {
    foreach ($table as $row) {
        // Expecting pattern: Subject, Max, Min, Obtained Theory, Practical
        if (count($row) >= 5 && is_numeric($row[1]) && is_numeric($row[2]) && is_numeric($row[3])) {
            $subject = strtoupper(trim($row[0]));
            if (
                !str_contains($subject, 'TOTAL') &&
                !str_contains($subject, 'GRAND') &&
                !str_contains($subject, 'GRADE') &&
                !str_contains($subject, 'RESULT')
            ) {
                $subjects[] = [
                    'subject' => $subject,
                    'max_marks_theory' => $row[1],
                    'min_marks_theory' => $row[2],
                    'obtained_theory' => $row[3],
                    'obtained_practical' => $row[4] ?? null,
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

// Helper Function
public function getTable($tableBlock, $blockMap) {
    $table = [];
    $rows = [];

    foreach ($tableBlock['Relationships'] ?? [] as $rel) {
        if ($rel['Type'] === 'CHILD') {
            foreach ($rel['Ids'] as $childId) {
                $cell = $blockMap[$childId];
                if ($cell['BlockType'] === 'CELL') {
                    $rowIdx = $cell['RowIndex'];
                    $colIdx = $cell['ColumnIndex'];

                    $cellText = '';
                    foreach ($cell['Relationships'] ?? [] as $cellRel) {
                        if ($cellRel['Type'] === 'CHILD') {
                            foreach ($cellRel['Ids'] as $textId) {
                                if (isset($blockMap[$textId]['Text'])) {
                                    $cellText .= $blockMap[$textId]['Text'] . ' ';
                                }
                            }
                        }
                    }

                    $rows[$rowIdx][$colIdx] = trim($cellText);
                }
            }
        }
    }

    // Normalize rows
    foreach ($rows as $row) {
        ksort($row);
        $table[] = array_values($row);
    }

    return $table;
}

      


}
