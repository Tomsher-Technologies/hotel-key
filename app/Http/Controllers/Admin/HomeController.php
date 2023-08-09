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

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index(){
        // $students = User::where('user_type','student')->withCount(['approved', 'rejected'])->get();
        // echo '<pre>';
        // print_r($students);
        // die;

        return  view('admin.dashboard');
    }

    public function getAllGuests(){
        // $query = HotelGuests::select('*')
        //             ->where('is_deleted',0)
        //             ->orderBy('id','DESC');
        // $guests = $query->paginate(10);
        $guests = '';
        return  view('admin.hotel_guests.index',compact('guests'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createCourse()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCourse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'banner_image' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('banner_image')) {
            $uploadedFile = $request->file('banner_image');
            $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
            $name = Storage::disk('public')->putFileAs(
                'courses',
                $uploadedFile,
                $filename
            );
           $imageUrl = Storage::url($name);
        }   

        $course = Courses::create([
            'name' => $request->name,
            'description' => $request->description,
            'banner_image' => $imageUrl
        ]);

        if ($request->divisions) {
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
        flash('Course has been created successfully')->success();
        return redirect()->route('all-courses');
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

    
   
}
