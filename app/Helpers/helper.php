<?php
  
use Carbon\Carbon;
use App\Models\UserDetails;
use App\Models\User;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "mm-active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

if (!function_exists('getTimeSlotHrMIn')) {
    function getTimeSlotHrMIn($interval, $start_time, $end_time)
    {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i=0;
        $time = [];
        while(strtotime($startTime) <= strtotime($endTime)){
            $start = $startTime;
            $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
            $i++;
            if(strtotime($startTime) <= strtotime($endTime)){
                $time[$i] = date('g:i A', strtotime($start)).' - '.date('g:i A', strtotime($end));
            }
        }
        return $time;
    }
}

function generateUniqueCode() {
    $code = 'HK'.mt_rand(100000, 999999);
    if (uniqueCodeNumberExists($code)) {
        return generateUniqueCode();
    }
    return $code;
}

function uniqueCodeNumberExists($code) {
    return UserDetails::where('profile_id', $code)->exists();
}


function getUserDetails($users){
    $query = User::select('users.*','ud.profile_id')
                ->leftJoin('user_details as ud','users.id','=','ud.user_id')
                ->where('user_type','user')
                ->where('is_deleted',0)
                ->where('is_active',1)
                ->whereIn('users.id', $users);
            
    $data = $query->orderBy('users.name','ASC')->get();
    // echo '<pre>';
    // print_r($data);
    // die;
    return $data;
}


