<?php
namespace App\Http\Controllers;

use App\Models\AgeGroups;
use App\Models\Category;
use App\Models\Marksheet;
use App\Models\Subcategory;
use App\utilities\helper;
use Aws\Textract\TextractClient;
use Illuminate\Http\Request;

class MarksheetController extends Controller
{
    public function index()
    {
        $user = helper::getTokenInfo();
    
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
    
        $marksheets = Marksheet::where('user_id', $user->id)->get(); // ⬅️ use get() here
    
        return view('dashboard.student.marksheets.index', compact('marksheets', 'user'));
    }
    

    public function create()
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }

        $categories = Category::with('subcategories')->get();
        $age_groups = AgeGroups::all();

        return view('dashboard.student.marksheets.create', compact('categories', 'user', 'age_groups'));
    }

    public function store(Request $request)
    {
        $user = helper::getTokenInfo();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        $request->validate([
            'description' => 'required',
            'image'       => 'required',
        ]);
        $imageUrl = config('constants.AWS_CREDENTIALS.CLOUDFRONTURL') . $request->image;
        $image_description = self::extractText($imageUrl);
        Marksheet::create([
            'description' => $request->description,
            'image_description' => $image_description,
            'image'       => $request->image,
            'user_id'     => $user->id, // assuming user is authenticated
        ]);

        return redirect()->route('marksheets.index')->with('success', 'Marksheet added successfully.');
    }

    public function show($id)
    {
        $user      = helper::getTokenInfo();
        $marksheet = Marksheet::findOrFail($id);

        return view('dashboard.student.marksheets.show', compact('marksheet', 'user'));
    }

    public function destroy($id)
    {
        $marksheet = Marksheet::findOrFail($id);
        $marksheet->delete();

        return redirect()->route('marksheets.index')->with('success', 'Marksheet deleted successfully.');
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    public function extractText($imageUrl)
    {

     //   $imageUrl = $request->input('url'); // CloudFront or S3 public URL

        // return $imageUrl;
        $textract = new TextractClient([
            'version' => 'latest',
            'region'  => 'ap-south-1', // e.g., us-west-2
                                       // No 'credentials' key needed — SDK will use IAM role or env vars
        ]);

        try {
            $imageContent = file_get_contents($imageUrl);

            if (! $imageContent) {
                throw new \Exception("Unable to download image from URL.");
            }

            $result = $textract->detectDocumentText([
                'Document' => [
                    'Bytes' => $imageContent,
                ],
            ]);

// Combine LINE blocks
            $text = '';
            foreach ($result->get('Blocks') as $block) {
                if ($block['BlockType'] === 'LINE') {
                    $text .= $block['Text'] . "\n";
                }
            }

            return $text;

        } catch (\Aws\Textract\Exception\TextractException $e) {
            return "";
        } catch (\Exception $e) {
            return "";
        }
    }

}
