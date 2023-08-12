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
        $hotels = User::where('user_type','hotel')
                        ->where('is_deleted', 0)
                        ->orderBy('name', 'ASC')
                        ->get()->toArray();
        return  view('admin.dashboard',compact('hotels'));
    }

    public function dashboardCounts(Request $request)
    {
        $startDate = $request->start;
        $endDate = $request->end;
        $hotelId = '';
        if(Auth::user()->user_type == 'hotel'){
            $hotelId = Auth::user()->id;
        }else{
            $hotelId = $request->hotel;
        }
        
        $checkin = HotelBookings::whereDate('checkin_date', '>=', $startDate)
                                ->whereDate('checkin_date', '<=', $endDate)
                                ->where('is_deleted', 0);
        if($hotelId != ''){
            $checkin->where('hotel_id',$hotelId);
        }

        $data['checkin'] = $checkin->count();
        // DB::enableQueryLog();
        $checkout = HotelBookings::whereDate('checkout_date', '>=', $startDate)
                                ->whereDate('checkout_date', '<=', $endDate)->where('is_deleted', 0);
        if($hotelId != ''){
            $checkout->where('hotel_id',$hotelId);
        }

        $data['checkout'] = $checkout->count();

        // dd(DB::getQueryLog());
        $data['users'] = User::whereDate('created_at', '>=', $startDate)
                                ->whereDate('created_at', '<=', $endDate)
                                ->where('user_type','user')
                                ->where('is_deleted', 0)
                                ->count();
        
        return json_encode(array('status' => true, 'data' => $data));
    }

    public function getAllBookings(Request $request){
        $search_term = $checkin_search = $checkout_search = '';

        if ($request->has('search_term')) {
            $search_term = $request->search_term;
        }
        if ($request->has('checkin')) {
            $checkin_search = $request->checkin;
        }
        if ($request->has('checkout')) {
            $checkout_search = $request->checkout;
        }

        $query = HotelBookings::with(['main_user','additional_users_without_main_user','booking_facilities'])
                            ->select('*')
                            ->where('hotel_id', Auth::user()->id)
                            ->where('is_deleted',0)
                            ->orderBy('id','DESC');

        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('hotel_bookings.room_number', 'LIKE', "%$search_term%");
                $query->orWhereHas('all_additional_users', function ($query)  use($search_term) {
                    $query->WhereHas('user', function ($query)  use($search_term)  {
                        $query->WhereHas('user_details', function ($query)  use($search_term)  {
                            $query->whereRaw("CONCAT(`first_name`,' ', `last_name`) LIKE '%{$search_term}%'")
                            ->orWhere('profile_id', 'LIKE', "%$search_term%");
                        })->orWhere('email', 'LIKE', "%$search_term%");
                    });
                });  
            }); 
        }

        if($checkin_search != '' || $checkout_search != ''){
            if($checkin_search != '' && $checkout_search != ''){
                $query->whereDate('checkin_date', '=', $checkin_search)
                ->whereDate('checkout_date',   '=', $checkout_search);
            }elseif($checkin_search == '' && $checkout_search != ''){
                $query->whereDate('checkout_date', '=', $checkout_search);
            }elseif($checkin_search != '' && $checkout_search == ''){
                $query->whereDate('checkin_date', '=', $checkin_search);
            }
        }

        $bookings = $query->paginate(10);
       
        return  view('admin.hotel_bookings.index',compact('bookings','search_term','checkin_search','checkout_search'));
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
            'booking_id' => $bookId,
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
                    'booking_id' => $bookId,
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
    public function editBooking(Request $request, $id)
    {
        $booking = HotelBookings::with(['main_user','additional_users_without_main_user','booking_facilities'])
                                ->where('hotel_id', Auth::user()->id)
                                ->where('is_deleted',0)
                                ->find($id);
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
        // echo '<pre>';
        // print_r($booking);
        // die;
        return view('admin.hotel_bookings.edit', compact('booking','users','facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBooking(Request $request, $id)
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

        $oldUser =  json_decode($request->oldUser);
        $oldfac =  json_decode($request->oldfac);
        $newUser = $request->additional_users;
        
        $checkinDate = $checkinTime = $checkoutDate = $checkoutTime =  '';

        $checkin = explode(' ', $request->check_in);
        $checkinDate = isset($checkin[0]) ? date('Y-m-d' , strtotime($checkin[0])) : '';
        $checkinTime = isset($checkin[1]) ? $checkin[1] : '';

        $checkout = explode(' ', $request->check_out);
        $checkoutDate = isset($checkout[0]) ? date('Y-m-d' , strtotime($checkout[0])) : '';
        $checkoutTime = isset($checkout[1]) ? $checkout[1] : '';

        $book = HotelBookings::find($id);
        $oldMainUser = $book->main_user_id;

        $notifications = [];
        if($oldMainUser != $request->main_user){
            $notifications[] = array(
                "user_id" => $request->main_user,
                'booking_id' => $book->id,
                "content"=> 'Room number '.$request->room_number.' of '.Auth::user()->name.' has been assigned to you, and your check-out time is '.$checkoutTime.' on ' . date('d M, Y',strtotime($checkoutDate)),
                'created_at' => date('Y-m-d H:i:s')
            );
        }

        $book->main_user_id = $request->main_user;
        $book->room_number = $request->room_number;
        $book->checkin_date = $checkinDate;
        $book->checkin_time = $checkinTime;
        $book->checkout_date = $checkoutDate;
        $book->checkout_time = $checkoutTime;
        $book->save();
        $bookId = $book->id;

        BookingAdditionalUsers::where('booking_id', $bookId)->delete();

        $userData[] = array(
            'booking_id' => $bookId,
            'user_id' => $request->main_user,
            'is_main_user' => 1,
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

                if(!in_array($users, $oldUser)){
                    $notifications[] = array(
                        "user_id" => $users,
                        'booking_id' => $bookId,
                        "content"=> 'Room number '.$request->room_number.' of '.Auth::user()->name.' has been assigned to you, and your check-out time is '.$checkoutTime.' on ' . date('d M, Y',strtotime($checkoutDate)),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                }   
            }
        }
        BookingAdditionalUsers::insert($userData);
        if(!empty($notifications)){
            Notifications::insert($notifications);
        }
       
        BookingFacilities::where('booking_id', $bookId)->delete();

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
        flash('Booking details has been updated successfully')->success();
        return redirect()->route('all-bookings');
    }

    public function deleteBooking(Request $request){
        HotelBookings::where('id', $request->id)->update(['is_deleted' => 1]);
        Notifications::where('booking_id', $request->id)->update(['is_deleted' => 1]);
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

    public function getProfile(Request $request){
        $details = User::with(['user_details'])->find(Auth::user()->id);
        return view('admin.profile.view',compact('details'));
    }

    public function updateProfile(Request $request)
    {
        $hotel = User::with('user_details')->findOrFail(Auth::user()->id);
        return view('admin.profile.hotel', compact('hotel'));
    }

    public function saveProfile(Request $request)
    {
        $id = Auth::user()->id;
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
        $user->save();
        $userId = $user->id;
       
        $data = [
            'first_name' => $request->name,
            'location' => $request->location,
            'phone_number' => $request->phone_number,
            'phone1' => $request->phone_number2,
            'profile_image' => ($logo != '') ? $logo : $presentLogo,
            'banner_image' => ($imageUrlB != '') ? $imageUrlB : $presentBannerImage,
        ];
        UserDetails::where('user_id', $userId)->update($data);

        flash('Profile details has been updated successfully')->success();
        return redirect()->route('update-profile');
    }
   
}
