<?php
namespace App\Http\Controllers;

use Aws\Textract\TextractClient;
use Illuminate\Http\Request;

class TextractController extends Controller
{
    public function extractTextold(Request $request)
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







    public function extractText(Request $request)
    {
        $imageUrl = $request->input('url');
    
        $textract = new TextractClient([
            'version' => 'latest',
            'region'  => 'ap-south-1',
        ]);
    
        try {
            $imageContent = file_get_contents($imageUrl);
    
            if (!$imageContent) {
                throw new \Exception("Unable to download image from URL.");
            }
    
            $result = $textract->analyzeDocument([
                'Document' => ['Bytes' => $imageContent],
                'FeatureTypes' => ['TABLES', 'FORMS'],
            ]);
    
            $blocks = $result->get('Blocks');
            $blockMap = [];
            $tables = [];
    
            foreach ($blocks as $block) {
                $blockMap[$block['Id']] = $block;
            }
    
            foreach ($blocks as $block) {
                if ($block['BlockType'] === 'TABLE') {
                    $tables[] = $this->getTable($block, $blockMap);
                }
            }
    
            // Get raw text
            $rawText = '';
            foreach ($blocks as $block) {
                if ($block['BlockType'] === 'LINE' && isset($block['Text'])) {
                    $rawText .= $block['Text'] . "\n";
                }
            }
    
            // ========== Extract Student Name ==========
            $studentName = null;
    
            // Try matching based on known patterns
            if (preg_match('/STUDENT[\'’`]?S NAME\s+([A-Z\s]+)/i', $rawText, $matches)) {
                $studentName = trim($matches[1]);
            } elseif (preg_match('/CERTIFIED THAT\s+([A-Z\s]+)\s+(SHRI|SUSHRI|WHOSE|FATHER\'S)/i', $rawText, $matches)) {
                $studentName = trim($matches[1]);
            } elseif (preg_match('/NAME IS\s+([A-Z\s]+)\s+(SHRI|SUSHRI)/i', $rawText, $matches)) {
                $studentName = trim($matches[1]);
            } elseif (preg_match('/\n([A-Z]{3,}\s+[A-Z]{3,})\n(SHRI|SUSHRI)/', $rawText, $fallback)) {
                $studentName = trim($fallback[1]);
            }
    
            // ========== Extract Subjects and Marks ==========
            $subjects = [];
            $lines = explode("\n", $rawText);
            foreach ($lines as $line) {
                $line = trim(preg_replace('/\s+/', ' ', $line)); // Normalize whitespace
            
                // Debug (optional)
                // \Log::info("LINE: " . $line);
            
                // Match with practical marks (Theory + Practical + Total)
                if (preg_match('/^([A-Z\s\(\)\-\+&\.]+)\s+100\s+33\s+(\d{2,3})\s+(\d{2,3})\s+(\d{2,3})$/', $line, $matches)) {
                    $subjects[] = [
                        'subject' => trim($matches[1]),
                        'max_marks_theory' => 100,
                        'min_marks_theory' => 33,
                        'obtained_theory' => $matches[2],
                        'obtained_practical' => $matches[3],
                        'total' => $matches[4],
                    ];
                    continue;
                }
            
                // Match without practical marks (Theory only + Total)
                if (preg_match('/^([A-Z\s\(\)\-\+&\.]+)\s+100\s+33\s+\-\s+(\d{2,3})\s+\-\s+(\d{2,3})$/', $line, $matches)) {
                    $subjects[] = [
                        'subject' => trim($matches[1]),
                        'max_marks_theory' => 100,
                        'min_marks_theory' => 33,
                        'obtained_theory' => $matches[2],
                        'obtained_practical' => null,
                        'total' => $matches[3],
                    ];
                    continue;
                }
            
                // Fallback: If total is present at end and subject looks valid
                if (preg_match('/^([A-Z\s\(\)\-\+&\.]+)\s+(\d{2,3})$/', $line, $matches)) {
                    $subjects[] = [
                        'subject' => trim($matches[1]),
                        'max_marks_theory' => null,
                        'min_marks_theory' => null,
                        'obtained_theory' => null,
                        'obtained_practical' => null,
                        'total' => $matches[2],
                    ];
                }
            }
    
            return response()->json([
                'name' => $studentName,
                'subjects' => $subjects,
                'raw_text' => $rawText,
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // Table helper
    public function getTable($tableBlock, $blockMap)
    {
        $table = [];
        $rows = [];
    
        foreach ($tableBlock['Relationships'] ?? [] as $rel) {
            if ($rel['Type'] === 'CHILD') {
                foreach ($rel['Ids'] as $childId) {
                    $cell = $blockMap[$childId] ?? null;
                    if ($cell && $cell['BlockType'] === 'CELL') {
                        $rowIdx = $cell['RowIndex'];
                        $colIdx = $cell['ColumnIndex'];
    
                        $cellText = '';
                        foreach ($cell['Relationships'] ?? [] as $cellRel) {
                            if ($cellRel['Type'] === 'CHILD') {
                                foreach ($cellRel['Ids'] as $textId) {
                                    $cellText .= $blockMap[$textId]['Text'] ?? '';
                                    $cellText .= ' ';
                                }
                            }
                        }
    
                        $rows[$rowIdx][$colIdx] = trim($cellText);
                    }
                }
            }
        }
    
        foreach ($rows as $row) {
            ksort($row);
            $table[] = array_values($row);
        }
    
        return $table;
    }









}
