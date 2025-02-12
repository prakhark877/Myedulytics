<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\utilities\helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Aws\S3\S3Client;
use Aws\CognitoIdentity\CognitoIdentityClient;
use Aws\CloudFront\CloudFrontClient;
use Aws\Connect\ConnectClient;

class AdminDashboardController extends Controller
{
    //


    public function getS3Token()
    {
        try {
            
            $client = new CognitoIdentityClient([
                'version' => 'latest',
                'region' => "ap-south-1"
            ]); // AWS::createClient('cognitoIdentity');
            $identityPoolId = "ap-south-1:6cfbe6e5-6132-4178-9059-bfcf1655c107";
            //echo $identityPoolId ;die;
            $duration = 86400;
            $providerName = "littleedventure";
            //Log::info($identityPoolId);
            //Log::info($providerName);
            $resultIdentity = $client->getOpenIdTokenForDeveloperIdentity(array(
                'IdentityPoolId' => $identityPoolId,
                'Logins' => array(
                    $providerName => 'super@admin.com'
                ),
                'TokenDuration' => $duration,
            ));
            //print_r($identityPoolId);die;
            if (isset($resultIdentity['IdentityId']) && $resultIdentity['Token']) {
                $returnArray['success'] = true;
                $returnArray['message'] = "Ok";
                $returnArray['identity_id'] = $resultIdentity['IdentityId'];
                $returnArray['token'] = $resultIdentity['Token'];
                $returnArray['identity_pool_id'] = $identityPoolId;
                $returnArray['public_bucket'] = "littleedvanture";
                $returnArray['private_bucket'] = "littleedvanture";
                $returnArray['cloudfront_url'] = "https://d2vmtwtvjnckox.cloudfront.net";
                $returnArray['s3_bucket_region'] = "ap-south-1";
            } else {
                $returnArray['success'] = false;
                $returnArray['message'] = "Failure";
            }
        } catch (Exception $e) {
            $returnArray['success'] = false;
            $returnArray['message'] = $e->getMessage();
           }
        return json_encode($returnArray);
    }

    public function adminDashboard(Request $request)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        return view('dashboard.admin.index')->with('user', $user);
    }

    public function showRegistrationForm()
    {
        return view('website.register-student');
    }

    public function register(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the new user
        $user = User::create([
            'student_id' => uniqid(),
            'first_name' => $request->input('name'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Log the user in after registration
        // auth()->login($user);

        // Redirect to the dashboard or another route
        return redirect()->route('register')->with('success', 'Registration successful! Please login to continue.');
    }

    public function studentList(Request $request)
    {
        $user = helper::getTokenInfo();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token not found');
        }
        ini_set('max_execution_time', 300);
        $search = $request->search;
        $fromdt = $request->fromdt;
        $todt = $request->todt;
        $users = User::where('users.type', 2)->select('*');
        $append = array();
        if ($fromdt != '' && $todt != '') {
            $users = $users->whereBetween('users.created_at', [$fromdt, $todt]);
            $append['fromdt'] = $fromdt;
            $append['todt'] = $todt;
        }

        if ($search != "") {
            $users = $users->orderBy('users.created_at', 'DESC')->where(function ($query) use ($search) {
                $query->where('users.first_name', 'like', '%' . $search . '%')
                // ->orWhere('users.created_at', 'like', '%'.$search.'%')
                    ->orWhere('users.dob', 'like', '%' . $search . '%')
                // ->orWhere('languagepreference', 'like', '%'.$search.'%')
                    ->orWhereRaw("CONCAT('users.first_name', ' ', 'users.last_name') LIKE ?", ['%' . $search . '%']);
            })->paginate(10);
            // $users->appends(['search' => $search]);
            $append['search'] = $search;
        } else {
            $users = $users->orderBy('users.created_at', 'DESC')->paginate(10);
        }

        if (sizeof($append) > 0) {
            // return "appends hai";
            $users = $users->appends($append);
        }

        //$users = UserModel::get();
        // return $users;

        foreach ($users as $ukey => $uvalue) {
            if ($uvalue->Experience != '' && $uvalue->Experience != 0) {
                $exp = $uvalue->Experience;
                $fm = fmod($exp, 12);
                $yr = ($exp - $fm) / 12;
                if ($fm == 0) {
                    $nexp = $yr . " yr(s).";
                } elseif ($fm != 0 && $yr == 0) {
                    $nexp = $fm . " month(s)";
                } else {
                    $nexp = $yr . " yr(s). " . $fm . " month(s)";
                }

                $users[$ukey]['Experience'] = $nexp;
            }

        }
       // return $users;
        return view("dashboard.admin.student_list", ['users' => $users, 'todt' => $todt, 'fromdt' => $fromdt, 'search' => $search]);
    }

}
