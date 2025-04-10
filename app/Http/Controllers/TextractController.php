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
return $result;
        $text = '';
        foreach ($result->get('Blocks') as $block) {
            if ($block['BlockType'] === 'WORD') {
                $text .= $block['Text'] . ' ';
            }
        }

        return response()->json([
            'text' => trim($text),
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
