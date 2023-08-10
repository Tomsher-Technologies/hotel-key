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
use App\Models\HotelFacilities;
use App\Models\HotelBookings;
use App\Models\BookingAdditionalUsers;
use App\Models\BookingFacilities;
use App\Models\Notifications;
use Auth;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index(){
       
        return  view('admin.dashboard');
    }

    public function getAllGuests(){
        $query = HotelBookings::with(['main_user','additional_users_without_main_user','booking_facilities'])
                            ->select('*')
                            ->where('hotel_id', Auth::user()->id)
                            ->where('is_deleted',0)
                            ->orderBy('id','DESC');
        $bookings = $query->paginate(10);
        
        return  view('admin.hotel_bookings.index',compact('bookings'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createBooking()
    {
        $users = User::select('*')
                        ->where('user_type','user')
                        ->where('is_deleted',0)
                        ->where('is_active',1)
                        ->orderBy('name','ASC')->get();
        $facilities = HotelFacilities::where('hotel_id', Auth::user()->id)
                        ->where('is_deleted', 0)
                        ->where('is_active', 1)
                        ->orderBy('facility_name','ASC')
                        ->get();
        return view('admin.hotel_bookings.create',compact('users','facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_user' => 'required',
            'room_number' => 'required',
            'check_in' => 'required',
            'check_out' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // echo '<pre>';
        // print_r($request->all());
        // die;

        $checkinDate = $checkinTime = $checkoutDate = $checkoutTime =  '';

        $checkin = explode(' ', $request->check_in);
        $checkinDate = isset($checkin[0]) ? date('Y-m-d' , strtotime($checkin[0])) : '';
        $checkinTime = isset($checkin[1]) ? $checkin[1] : '';

        $checkout = explode(' ', $request->check_out);
        $checkoutDate = isset($checkout[0]) ? date('Y-m-d' , strtotime($checkout[0])) : '';
        $checkoutTime = isset($checkout[1]) ? $checkout[1] : '';

        $book = new HotelBookings();
        $book->hotel_id = Auth::user()->id;
        $book->main_user_id = $request->main_user;
        $book->room_number = $request->room_number;
        $book->checkin_date = $checkinDate;
        $book->checkin_time = $checkinTime;
        $book->checkout_date = $checkoutDate;
        $book->checkout_time = $checkoutTime;
        $book->save();
        $bookId = $book->id;

        $userData[] = array(
            'booking_id' => $bookId,
            'user_id' => $request->main_user,
            'is_main_user' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        $notifications[] = array(
            "user_id" => $request->main_user,
            "content"=> 'Room number '.$request->room_number.' of '.Auth::user()->name.' has been assigned to you, and your check-out time is '.$checkoutTime.' on ' . date('d M, Y',strtotime($checkoutDate)),
            'created_at' => date('Y-m-d H:i:s')
        );

        if(!empty($request->additional_users)){
            foreach($request->additional_users as $users){
                $userData[] = array(
                    'booking_id' => $bookId,
                    'user_id' => $users,
                    'is_main_user' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $notifications[] = array(
                    "user_id" => $users,
                    "content"=> 'Room number '.$request->room_number.' of '.Auth::user()->name.' has been assigned to you, and your check-out time is '.$checkoutTime.' on ' . date('d M, Y',strtotime($checkoutDate)),
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
        }
        BookingAdditionalUsers::insert($userData);
        Notifications::insert($notifications);
        if(!empty($request->facilities)){
            $facData = [];
            foreach($request->facilities as $fac){
                $facData[] = array(
                    'booking_id' => $bookId,
                    'facility_id' => $fac,
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
            BookingFacilities::insert($facData);
        }
        
        flash('Booking has been created successfully')->success();
        return redirect()->route('all-bookings');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCourse(Request $request, $id)
    {
        $course = Courses::findOrFail($id);
        $course_divisions = CourseDivisions::where('courses_id', $id)->get();

        $divisions = [];

        foreach ($course_divisions as $div) {
            $arr = [];
            $arr['division_name'] = $div->title;
            $arr['division_description'] = $div->description;
            $arr['division_status'] = $div->is_active;
            $divisions[] = $arr;
        }

        $divisions = json_encode($divisions);
        return view('admin.courses.edit', compact('course','divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCourse(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $course = Courses::findOrFail($id);

        $presentImage = $course->banner_image;
        $imageUrl = '';
        if ($request->hasFile('banner_image')) {
            $uploadedFile = $request->file('banner_image');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'courses',
                $uploadedFile,
                $filename
            );
           $imageUrl = Storage::url($name);
           if($presentImage != '' && File::exists(public_path($presentImage))){
                unlink(public_path($presentImage));
            }
        }   

        $course->name = $request->name;
        $course->description = $request->description;
        $course->banner_image = ($imageUrl != '') ? $imageUrl : $presentImage;
        $course->is_active = $request->is_active;
        $course->save();

        if($request->divisions) {
            CourseDivisions::where('courses_id', $id)->delete();
            foreach ($request->divisions as $div) {
                if(isset($div['division_name']) && $div['division_name'] != ''){
                    CourseDivisions::create([
                        'courses_id' => $course->id,
                        'title' =>  $div['division_name'],
                        'description' =>  isset($div['division_description']) ? $div['division_description'] : NULL,
                        'is_active' => isset($div['division_status']) ? $div['division_status'] : 1,
                    ]);
                }
            }
        }
        flash('Course has been updated successfully')->success();
        return redirect()->route('all-courses');
    }

    public function deleteCourse(Request $request){
        Courses::where('id', $request->id)->update(['is_deleted' => 1]);
    }

    public function getAllFacilities(){
        $facilities = HotelFacilities::where('hotel_id', Auth::user()->id)
                                    ->where('is_deleted', 0)
                                    ->orderBy('id','DESC')
                                    ->paginate(15);
        return  view('admin.facilities.index',compact('facilities'));
    }

    public function storeFacility(Request $request){
        $id = $request->id;
        $facility = $request->facility;
        $status = $request->status;
        $facId = '';
        if($id != ''){
            $fac = HotelFacilities::find($id);
            $fac->facility_name = $facility;
            $fac->is_active    =$status ;
            $fac->save();
            $facId = $fac->id;
        }else{
            $fac = new HotelFacilities();
            $fac->hotel_id = Auth::user()->id;
            $fac->facility_name = $facility;
            $fac->is_active    =$status ;
            $fac->save();
            $facId = $fac->id;
        }
        return $facId;
    }

    public function deleteFacility(Request $request){
        HotelFacilities::where('id', $request->id)->update(['is_deleted' => 1]);
    }
   
}
