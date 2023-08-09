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
use Auth;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function getAllHotels(Request $request){
        $search_term = '';

        if ($request->has('search_term')) {
            $search_term = $request->search_term;
        }

        $query = User::with('user_details')->select('*')
                        ->where('user_type','hotel')
                        ->where('is_deleted',0)
                        ->orderBy('id','DESC');
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('users.name', 'LIKE', "%$search_term%")
                ->orWhere('users.email', 'LIKE', "%$search_term%")
                ->orWhereHas('user_details', function ($query)  use($search_term) {
                    $query->where('location', 'LIKE', "%$search_term%")
                    ->orWhere('phone_number', 'LIKE', "%$search_term%");
                });   
            }); 
            
        }
        $hotels = $query->paginate(10);
        
        return  view('admin.hotels.index',compact('hotels','search_term'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createHotel()
    {
        return view('admin.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeHotel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
            'location' => 'required',
            'logo' => 'required',
            'banner_image' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->user_type = 'hotel';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $userId = $user->id;

        if($userId){
            $bannerImage = '';
            if ($request->hasFile('banner_image')) {
                $uploadedFile = $request->file('banner_image');
                $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
                $name = Storage::disk('public')->putFileAs(
                    'hotels/'.$userId,
                    $uploadedFile,
                    $filename
                );
               $bannerImage = Storage::url($name);
            } 
            $logo = '';
            if ($request->hasFile('logo')) {
                $uploadedFile = $request->file('logo');
                $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
                $name = Storage::disk('public')->putFileAs(
                    'hotels/'.$userId,
                    $uploadedFile,
                    $filename
                );
               $logo = Storage::url($name);
            } 

            $uDetails = new UserDetails();
            $uDetails->user_id = $user->id;
            $uDetails->first_name = $request->name;
            $uDetails->location = $request->location;
            $uDetails->phone_number = $request->phone_number;
            $uDetails->profile_image = $logo;
            $uDetails->banner_image = $bannerImage;
            $uDetails->save();
        }
        flash('Hotel has been created successfully')->success();
        return redirect()->route('all-hotels');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editHotel(Request $request, $id)
    {
        $hotel = User::with('user_details')->findOrFail($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateHotel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users,email,'.$id,
            'phone_number' => 'required',
            'location' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::with(['user_details'])->findOrFail($id);

        $presentBannerImage = $user->user_details->banner_image;
        $imageUrlB = '';
        if ($request->hasFile('banner_image')) {
            $uploadedFile = $request->file('banner_image');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'hotels/'.$id,
                $uploadedFile,
                $filename
            );
           $imageUrlB = Storage::url($name);
           if($presentBannerImage != '' && File::exists(public_path($presentBannerImage))){
                unlink(public_path($presentBannerImage));
            }
        } 
        $presentLogo = $user->user_details->profile_image;
        $logo = '';
        if ($request->hasFile('logo')) {
            $uploadedFilel = $request->file('logo');
            $filenamel =    strtolower(Str::random(2)).time().'.'. $uploadedFilel->getClientOriginalName();
            $namel = Storage::disk('public')->putFileAs(
                'hotels/'.$id,
                $uploadedFilel,
                $filenamel
            );
            $logo = Storage::url($namel);
            if($presentLogo != '' && File::exists(public_path($presentLogo))){
                unlink(public_path($presentLogo));
            }
        } 
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }
        $user->is_active = $request->is_active;
        $user->save();
        $userId = $user->id;
       
        $data = [
            'first_name' => $request->name,
            'location' => $request->location,
            'phone_number' => $request->phone_number,
            'profile_image' => ($logo != '') ? $logo : $presentLogo,
            'banner_image' => ($imageUrlB != '') ? $imageUrlB : $presentBannerImage,
        ];
        UserDetails::where('user_id', $userId)->update($data);

        flash('Hotel details has been updated successfully')->success();
        return redirect()->route('all-hotels');
    }

    public function deleteHotel(Request $request){
        User::where('id', $request->id)->update(['is_deleted' => 1]);
    }

    
   
}
