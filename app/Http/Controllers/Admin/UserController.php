<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Courses;
use App\Models\CourseDivisions;
use App\Models\CoursePackages;
use App\Models\PackageModules;
use App\Models\CourseClasses;
use App\Models\TeacherDivisions;
use App\Models\States;
use App\Models\Tutorials;
use Auth;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function getAllUsers(Request $request){
        $search_term = '';

        if ($request->has('search_term')) {
            $search_term = $request->search_term;
        }

        $query = User::with('user_details')->select('*')
                        ->where('user_type','user')
                        ->where('is_deleted',0)
                        ->orderBy('id','DESC');
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('users.name', 'LIKE', "%$search_term%")
                ->orWhere('users.email', 'LIKE', "%$search_term%")
                ->orWhereHas('user_details', function ($query)  use($search_term) {
                    $query->where('profile_id', 'LIKE', "%$search_term%")
                    ->orWhere('phone_number', 'LIKE', "%$search_term%");
                });   
            }); 
            
        }
        $users = $query->paginate(10);
        
        return  view('admin.users.index',compact('users','search_term'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'phone_number' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->user_type = 'user';
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $userId = $user->id;

        if($userId){
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
            } 
            

            $uDetails = new UserDetails();
            $uDetails->user_id = $user->id;
            $uDetails->profile_id = generateUniqueCode();
            $uDetails->first_name = $request->first_name;
            $uDetails->last_name = $request->last_name;
            $uDetails->gender = $request->gender;
            $uDetails->date_of_birth = $request->dob;
            $uDetails->phone_number = $request->phone_number;
            $uDetails->language = 'en';
            $uDetails->profile_image = $profileImage;
            $uDetails->save();
        }
        flash('User has been created successfully')->success();
        return redirect()->route('all-users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUser(Request $request, $id)
    {
        $user = User::with('user_details')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:100|unique:users,email,'.$id,
            'phone_number' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::with(['user_details'])->findOrFail($id);

        $presentLogo = $user->user_details->profile_image;
        $logo = '';
        if ($request->hasFile('profile_image')) {
            $uploadedFilel = $request->file('profile_image');
            $filenamel =    strtolower(Str::random(2)).time().'.'. $uploadedFilel->getClientOriginalName();
            $namel = Storage::disk('public')->putFileAs(
                'users/'.$id,
                $uploadedFilel,
                $filenamel
            );
            $logo = Storage::url($namel);
            if($presentLogo != '' && File::exists(public_path($presentLogo))){
                unlink(public_path($presentLogo));
            }
        } 
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }
        $user->is_active = $request->is_active;
        $user->save();
        $userId = $user->id;
       
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->dob,
            'phone_number' => $request->phone_number,
            'profile_image' => ($logo != '') ? $logo : $presentLogo
        ];
        UserDetails::where('user_id', $userId)->update($data);

        flash('User details has been updated successfully')->success();
        return redirect()->route('all-users');
    }

    public function deleteUser(Request $request){
        User::where('id', $request->id)->update(['is_deleted' => 1]);
    }

    public function getAllStaffs(Request $request){
        $search_term = '';

        if ($request->has('search_term')) {
            $search_term = $request->search_term;
        }

        $query = User::with('user_details')->select('*')
                        ->where('user_type','staff')
                        ->where('parent_id', Auth::user()->id)
                        ->where('is_deleted',0)
                        ->orderBy('id','DESC');
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('users.name', 'LIKE', "%$search_term%")
                ->orWhere('users.email', 'LIKE', "%$search_term%")
                ->orWhereHas('user_details', function ($query)  use($search_term) {
                    $query->where('profile_id', 'LIKE', "%$search_term%")
                    ->orWhere('phone_number', 'LIKE', "%$search_term%");
                });   
            }); 
            
        }
        $staffs = $query->paginate(10);
        
        return  view('admin.staffs.index',compact('staffs','search_term'));
    }
   
    public function createStaff()
    {
        return view('admin.staffs.create');
    }

    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'phone_number' => 'required',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->parent_id = Auth::user()->id;
        $user->user_type = 'staff';
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $userId = $user->id;

        if($userId){
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
            } 
            

            $uDetails = new UserDetails();
            $uDetails->user_id = $user->id;
            $uDetails->first_name = $request->first_name;
            $uDetails->last_name = $request->last_name;
            $uDetails->phone_number = $request->phone_number;
            $uDetails->language = 'en';
            $uDetails->profile_image = $profileImage;
            $uDetails->save();
        }
        flash('Staff has been created successfully')->success();
        return redirect()->route('all-staffs');
    }

    public function editStaff(Request $request, $id)
    {
        $staff = User::with('user_details')->findOrFail($id);
        
        return view('admin.staffs.edit', compact('staff'));
    }

    public function updateStaff(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:100|unique:users,email,'.$id,
            'phone_number' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::with(['user_details'])->findOrFail($id);

        $presentLogo = $user->user_details->profile_image;
        $logo = '';
        if ($request->hasFile('profile_image')) {
            $uploadedFilel = $request->file('profile_image');
            $filenamel =    strtolower(Str::random(2)).time().'.'. $uploadedFilel->getClientOriginalName();
            $namel = Storage::disk('public')->putFileAs(
                'users/'.$id,
                $uploadedFilel,
                $filenamel
            );
            $logo = Storage::url($namel);
            if($presentLogo != '' && File::exists(public_path($presentLogo))){
                unlink(public_path($presentLogo));
            }
        } 
        $user->name = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }
        $user->is_active = $request->is_active;
        $user->save();
        $userId = $user->id;
       
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'profile_image' => ($logo != '') ? $logo : $presentLogo
        ];
        UserDetails::where('user_id', $userId)->update($data);

        flash('Staff details has been updated successfully')->success();
        return redirect()->route('all-staffs');
    }

    public function deleteStaff(Request $request){
        User::where('id', $request->id)->update(['is_deleted' => 1]);
    }

    public function getAllTutorials()
    {
        $tutorials = Tutorials::orderBy('id','desc')->paginate(10);
        return view('admin.tutorials.index', compact('tutorials'));
    }

    public function createTutorial(){
        return view('admin.tutorials.create');
    }

    public function storeTutorial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $iconImage = '';
        if ($request->hasFile('icon_image')) {
            $uploadedFile = $request->file('icon_image');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'tutorials',
                $uploadedFile,
                $filename
            );
            $iconImage = Storage::url($name);
        } 

        $tut = new Tutorials;
        $tut->title = $request->title;
        $tut->link = $request->link;
        $tut->image = $iconImage;
        $tut->save();
    
        flash('Tutorial has been created successfully')->success();
        return redirect()->route('all-tutorials');
    }

    public function editTutorial(Request $request, $id)
    {
        $tutorial = Tutorials::findOrFail($id);
        
        return view('admin.tutorials.edit', compact('tutorial'));
    }

    public function updateTutorial(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $tutorial = Tutorials::find($id);

        $presentImage = $tutorial->image;
        $logo = '';
        if ($request->hasFile('icon_image')) {
            $uploadedFilel = $request->file('icon_image');
            $filenamel =    strtolower(Str::random(2)).time().'.'. $uploadedFilel->getClientOriginalName();
            $namel = Storage::disk('public')->putFileAs(
                'tutorials',
                $uploadedFilel,
                $filenamel
            );
            $logo = Storage::url($namel);
            if($presentImage != '' && File::exists(public_path($presentImage))){
                unlink(public_path($presentImage));
            }
        } 
        $tutorial->title = $request->title;
        $tutorial->link = $request->link;
        $tutorial->image = ($logo != '') ? $logo : $presentImage;
        $tutorial->save();
        
        flash('Tutorial details has been updated successfully')->success();
        return redirect()->route('all-tutorials');
    }

    public function deleteTutorial(Request $request){
        Tutorials::where('id', $request->id)->delete();
    }
}
