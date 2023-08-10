<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\States;
use App\Models\Courses;
use App\Models\CoursePackages;
use App\Models\StudentPackages;
use App\Models\AssignTeachers;
use App\Models\TeacherSlots;
use App\Models\Bookings;
use Validator;
use Hash;
use Str;
use File;
use Storage;
use DB;

class ApiAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['status' => false, 'message' => 'Invalid login details', 'data' => []], 401);
        }else{
            if(auth('api')->user()->is_deleted == 1){
                return response()->json(['status' => false, 'message' => 'Your account is Deleted.', 'data' => []], 401);
            }elseif(auth('api')->user()->is_active == 0){
                return response()->json(['status' => false, 'message' => 'Your account is Disabled.', 'data' => []], 401);
            }else{
                return $this->createNewToken($token);
            }
        }
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json(['status' => false, 'message' => 'The email has already been taken.', 'data' => []  ], 400);
        }
        $user = new User;
        $user->user_type = 'user';
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $userId = $user->id;

        if($userId){
            $uDetails = new UserDetails();
            $uDetails->user_id = $user->id;
            $uDetails->profile_id = generateUniqueCode();
            $uDetails->first_name = $request->first_name;
            $uDetails->last_name = $request->last_name;
            $uDetails->gender = $request->gender;
            $uDetails->date_of_birth = $request->date_of_birth;
            $uDetails->phone_number = $request->phone_number;
            $uDetails->language = 'en';
            $uDetails->save();
        }
       
        return response()->json([
            'status' => true,
            'message' => 'Successfully registered.',
            'data' => []
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();
        return response()->json(['status' => true,'message' => 'User successfully signed out','data' => []]);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('api')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(Request $request) {
        $user = User::select('users.id','ud.first_name','ud.last_name','users.email','ud.profile_id','ud.gender','ud.date_of_birth','ud.phone_number','ud.profile_image')
                    ->leftJoin('user_details as ud','ud.user_id','=','users.id')
                    ->where('users.id', $request->id)
                    ->where('users.is_deleted',0)
                    ->get();
                    
        if(isset($user[0])){
            $user[0]['profile_image'] = ($user[0]['profile_image'] != '') ? asset($user[0]['profile_image']) : '';

            $allFields = ['email','first_name', 'last_name', 'gender', 'date_of_birth', 'phone_number','profile_image'];
            $filledField = 0;

            if($user[0]['email'] != ''){
                $filledField++;
            }
            if($user[0]['first_name'] != ''){
                $filledField++;
            }
            if($user[0]['last_name'] != ''){
                $filledField++;
            }
            if($user[0]['gender'] != ''){
                $filledField++;
            }
            if($user[0]['date_of_birth'] != ''){
                $filledField++;
            }
            if($user[0]['phone_number'] != ''){
                $filledField++;
            }
            if($user[0]['profile_image'] != ''){
                $filledField++;
            }
            $percentage = ($filledField / count($allFields)) * 100;
            $user[0]['percentage'] = round($percentage);
            return response()->json([ 'status' => true, 'message' => 'Success', 'data' => $user]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'User details not found.', 'data' => []]);
        }
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'status' => true,
            'message' => 'Successfully loggedIn',
            'data' => auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth('api')->factory()->getTTL() * 60,
            
        ]);
    }

   
    
    // Update user profile details
    public function updateUserData(Request $request){
        $userId         = $request->user_id;
        $first_name     = $request->first_name;
        $last_name      = $request->last_name;
       
        $user = User::find($userId);
        $user->name = $first_name.' '.$last_name;
        $user->save();

        $data = [
            'first_name' => $first_name, 
            'last_name' => $last_name, 
            'gender' => $request->gender, 
            'date_of_birth' => $request->date_of_birth, 
            'phone_number' => $request->phone_number, 
        ];

        UserDetails::where('user_id',$userId)->update($data);
        return response()->json(['status' => true,'message' => 'User details updated successfully', 'data' => []]);
    }
    
    // Update user profile image
    public function updateProfileImage(Request $request){
        $userId = $request->user_id;

        $userdata = UserDetails::where('user_id', $userId)->get();
      
        if(isset($userdata[0])){
            $presentImage = $userdata[0]['profile_image'];

            $profileImage = '';
            if ($request->hasFile('profile_image')) {
                $uploadedFile = $request->file('profile_image');
                $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
                $name = Storage::disk('public')->putFileAs(
                    'users/'.$userId,
                    $uploadedFile,
                    $filename
                );
                $profileImage = Storage::url($name);
                if($presentImage != '' && File::exists(public_path($presentImage))){
                    unlink(public_path($presentImage));
                }
                $update =  UserDetails::where('user_id', $userId)->update(['profile_image' => $profileImage]);
                return response()->json(['status' => true,'message' => 'User image updated successfully', 'data' => ['profile_image' => asset($profileImage)]]);
            }else{
                return response()->json(['status' => false,'message' => 'Failed to update user image', 'data' => []]);
            }
        }else{
            return response()->json(['status' => false,'message' => 'User not found', 'data' => []]);
        }
    }

    public function changePassword(Request $request)
    {
        $userId = $request->user_id;
        $user = User::find($userId);
        if (!Hash::check($request->get('current_password'), $user->password)){
            return response()->json(['status' => false,'message' => 'Current Password is Invalid', 'data' => []]);
        }
 
        if (strcmp($request->get('current_password'), $request->new_password) == 0){
            return response()->json(['status' => false,'message' => 'New Password cannot be same as your current password.', 'data' => []]);
        }

        $user->password =  Hash::make($request->new_password);
        $user->save();
        return response()->json(['status' => true,'message' => 'Password Changed Successfully', 'data' => []]);
    }

    public function getAllHotels(){
        $hotels = User::with('user_details')->select('*')
                    ->where('user_type','hotel')
                    ->where('is_active',1)
                    ->where('is_deleted',0)
                    ->orderBy('name','ASC')->get()->toArray();
        if(isset($hotels[0])){
            $hotel = [];
            foreach($hotels as $hot){
                $hotel[] = array(
                    "id" =>$hot["id"],
                    "name"=>$hot["name"],
                    "email"=> $hot["email"],
                    "phone_number1"=>$hot["user_details"]["phone_number"]?? "",
                    "phone_number2"=>$hot["user_details"]["phone1"]?? "",
                    "location"=>$hot["user_details"]["location"]?? "",
                    "profile_image"=> ($hot['user_details']['profile_image'] != '') ? asset($hot['user_details']['profile_image']) : '',
                    "banner_image"=> ($hot['user_details']['banner_image'] != '') ? asset($hot['user_details']['banner_image']) : '',
                );
            }
            return response()->json([ 'status' => true, 'message' => 'Success', 'data' => $hotel]);
        }else{
            return response()->json([ 'status' => false, 'message' => 'Hotels not found.', 'data' => []]);
        }  
    }

}


