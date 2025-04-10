<?php
namespace App\Http\Controllers;

use Aws\Textract\TextractClient;
use Illuminate\Support\Facades\Storage;

class TextractController extends Controller
{
    public function extractText()
    {
        $textract = new TextractClient([
            'version' => 'latest',
            'region' => config('services.aws.region'),
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ]
        ]);

        try {
            $imagePath = storage_path('app/public/1.jpg'); // Make sure the image exists
            $result = $textract->detectDocumentText([
                'Document' => [
                    'Bytes' => file_get_contents($imagePath),
                ]
            ]);

            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] == 'WORD') {
                    $text .= $block['Text'] . ' ';
                }
            }

            return response()->json([
                'text' => trim($text)
            ]);

        } catch (\Aws\Textract\Exception\TextractException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
