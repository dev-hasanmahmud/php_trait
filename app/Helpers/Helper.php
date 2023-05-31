<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function upload_url($path)
{
    return env("APP_URL") . "/public/" . $path;
}

use App\Area;
use App\Notification;
use App\Setting;
use App\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

function active_class_path($uri = '')
{
    $active = '';

    if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
        $active = 'active';
    }

    return $active;
}

function curl_read($endpoint, $authtoken)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
//            "authorization: Bearer $authtoken",
            "cache-control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $message = [
            'status' => 'error',
            'response' => "cURL Error #:" . $err,
        ];

        return response()->json($message);
    } else {
        return $response;
    }
}

function isLocal()
{
    if (strpos(url('/'), 'localhost') !== false || strpos(url('/'), '127.0.0.1') !== false) {
        return true;
    }
    return false;
}

//------------ START : CUSTOM ASSET FUNCTION -----------------------------------
function custom_asset($path, $secure = null)
{
    if (App::environment('local')) {
        return asset($path, $secure);
    }
    return url('/') . '/public/' . $path;
}

function custom_asset_bk($path, $secure = null)
{
    //if(!isLocal()) {
    $path = 'public/' . $path;
    //}
    return asset($path, $secure);
}

function english_to_bangla($string)
{
    $engDATE = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'am', 'pm');
    $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারি', 'ফেব্রুয়ারি ', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', '
বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'পূর্বাহ্ণ', 'অপরাহ্ণ');
    $output = str_replace($engDATE, $bangDATE, $string);
    return $output;
}

function bdtFormat($n, $d = 0)
{
    if (!isset($n) || $n == "") {
        return '';
    }

    $n = number_format($n, $d, '.', '');
    $n = strrev($n);

    if ($d) {
        $d++;
    }

    $d += 3;

    if (strlen($n) > $d) {
        $n = substr($n, 0, $d) . ','
            . implode(',', str_split(substr($n, $d), 2));
    }

    $data = strrev($n);
    return $data;
}

function mongo_date_to_regular_date($mongo_data_date)
{
    if (strpos($mongo_data_date, '-')) {
        $time = date('Y-m-d', strtotime($mongo_data_date));
        return $time;
    } else {
        $utcdatetime = $mongo_data_date;
        $datetime = $utcdatetime->toDateTime();
        $time = $datetime->format(DATE_RSS);
        $time = date('Y-m-d', strtotime($time));
        return $time;
    }

}

function get_geo_id($bbs_code, $type, $parent_id = null)
{
    $data = array();
    if ($type == 'D') {
        $type_id = 5;
        $data = Area::select('id')->where('type_id', $type_id)->where('bbscode', $bbs_code)->first();
    } elseif ($type == 'UP') {
        $type_id = 6;
        $data = Area::select('id')->where('type_id', $type_id)->where('parent_id', $parent_id)->where('bbscode', $bbs_code)->first();
    }
    if (empty($data)) {
        return false;
    }
    return $data->id;
}

function get_set_session_value($user_id, $page, $flag, $value = null)
{
    if ($flag == 'SET') {
        $save_data = UserSession::updateOrCreate(
            [
                'user_id' => $user_id,
                'page' => $page,
            ],
            [
                'value' => $value,
            ]
        );
        if ($save_data) {
            return true;
        } else {
            return false;
        }
    } else {
        $data = UserSession::where('user_id', $user_id)->where('page', $page)->first();
        if (!empty($data)) {
            return $data->value;
        } else {
            return false;
        }
    }
}

function convert_bdt_format($n, $d = 0)
{
    if (!isset($n) || $n == "") {
        return '';
    }

    $n = number_format($n, $d, '.', '');
    $n = strrev($n);

    if ($d) {
        $d++;
    }

    $d += 3;

    if (strlen($n) > $d) {
        $n = substr($n, 0, $d) . ',' . implode(',', str_split(substr($n, $d), 2));
    }
    $data = strrev($n);
    return $data;
}

function rw($data)
{
    echo "<pre>";
    print_r($data);
    die;
}

function get_settings($name)
{
    $data = Setting::where('name', $name)->first();
    return $data->value;
}

function trim_text($input, $length, $ellipses = true, $strip_html = true)
{
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    // ASCII
    // UTF-8
    if (mb_detect_encoding($input) == 'ASCII') {
        $length = $length / 3;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}

function get_percentage($current_value, $base_value)
{
    $d = $base_value - $current_value;
    if ($base_value != 0) {
        $percentage = ($d * 100) / $base_value;
        if ($current_value < $base_value) {
            $percentage = "-" . $percentage;
        }
    } else {
        $percentage = $current_value;
    }
    return $percentage;
}

function get_percentage_to_hundrade($current_value, $base_value)
{
    if ($base_value == 0) {
        return 0;
    }
    $percentage = ($current_value * 100) / $base_value;
    return number_format($percentage, 2, '.', '');
}

function get_firebase_instance()
{
    $serviceAccount = Kreait\Firebase\ServiceAccount::fromJsonFile(__DIR__ . '/a2i-dashboard-firebase-adminsdk-0vpnm-115846ba1b.json');
    $firebase = (new Kreait\Firebase\Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://a2i-dashboard.firebaseio.com')
        ->create();

    return $firebase->getDatabase();
}

function sendMail($to_email, $body, $subject)
{
    $to_name = '';
    //$to_email = 'tanim2reja@gmail.com';
    //$subject ='Forget Password !! (Dashboard)';
    //$body="This is Test Body -----------------------------------------Body Body--------------";
    $data = array('name' => 'Dear User', 'body' => $body);
    $fromAddress = 'abc@abc.com';
    $fromName = 'Dashboard';

    $mailResponse = Mail::send('admin.emails.mail', $data, function ($message)
    use ($to_name, $to_email, $subject, $fromAddress, $fromName) {
        $message->to($to_email, $to_name)
            ->subject($subject);
        $message->from($fromAddress, $fromName);
    });
}

function generateRadmonText()
{

    return rand(10000, 0);
    //dd(str_shuffle($randomNum));

}

function getCurlPostForSMS($mobile, $sms)
{

    //$mobile="01724595314";
    //$sms="Tesing";
    $user = 'sdg_user';
    $psw = 'e8@Tuk9R';
    $sms = addslashes($sms);
    $sms = urlencode($sms);
    $url = 'https://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=' . $user . '&pass=' . $psw . '&mobile=' . $mobile . '&charset=UTF-8&sms=' . $sms;

    /* // create a new cURL resource
    $ch = curl_init();

    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    if(!$result) {
    return curl_error($ch);
    } else {
    return json_decode($result);
    }
    curl_close($ch); */

    $ch = curl_init(); // initialize CURL
    curl_setopt($ch, CURLOPT_POST, false); // Set CURL Post Data
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // i have added this to skip openssl error
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    // if(!$output) {
    //     return curl_error($ch);
    // }
    // curl_close($ch);
    // return $output;
    if (!$output) {
        return false;
    }
    curl_close($ch);
    return true;

}

function save_notification_data($messege, $link = null, $from_user_id, $to_user_id, $executed = 0, $created_by = null, $updated_by = null, $type = null, $button = null, $button_value = null, $button_link = null)
{
    // return true;

    $data = new App\Notification;

    $data->messege = $messege;
    $data->link = $link;
    $data->from_user_id = $from_user_id;
    $data->to_user_id = $to_user_id;
    $data->executed = $executed;
    $data->updated_by = $updated_by;
    $data->created_by = $created_by;
    $data->type = $type;

    $data->button = $button;
    $data->button_value = $button_value;
    $data->button_link = $button_link;

    if ($data->save()) {
        $db_data = Notification::where('id', $data->id)->first();
        //return true;
        //firebase
        try {
            $serviceAccount = Kreait\Firebase\ServiceAccount::fromJsonFile(__DIR__ . '/a2i-dashboard-firebase-adminsdk-0vpnm-115846ba1b.json');
            $firebase = (new Kreait\Firebase\Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://a2i-dashboard.firebaseio.com')
                ->create();

            $database = $firebase->getDatabase();

            $newPost = $database
                ->getReference('emcrp')
                ->push([
                    'db_id' => $db_data->id,
                    'messege' => $db_data->messege,
                    'link' => $db_data->link,
                    'from_user_id' => $db_data->from_user_id,
                    'to_user_id' => $db_data->to_user_id,
                    'executed' => $db_data->executed,
                    'type' => $db_data->type,
                    'button' => $db_data->button,
                    'button_value' => $db_data->button_value,
                    'button_link' => $db_data->button_link . "&n_id=" . $db_data->id,
                    'created_by' => $db_data->created_by,
                    'updated_by' => $db_data->updated_by,
                    'created_at' => $db_data->created_at,
                    'updated_at' => $db_data->updated_at,

                ]);
        } catch (Throwable $e) {
            return true;
        }

        //dd($newPost);
        return true;
    } else {
        return false;
    }

}

function update_notification_data($n_id)
{
    //dd($n_id);
    $serviceAccount = Kreait\Firebase\ServiceAccount::fromJsonFile(__DIR__ . '/a2i-dashboard-firebase-adminsdk-0vpnm-115846ba1b.json');
    $firebase = (new Kreait\Firebase\Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://a2i-dashboard.firebaseio.com')
        ->create();

    $database = $firebase->getDatabase();

    $ref = $database->getReference('notifications');
    $value = $ref->orderByChild('db_id')->equalTo((int)$n_id)->getSnapshot()->getValue();
    $childKey = array_keys($value)[0];

    $postData = [
        'executed' => 1,
    ];

    $ref->getChild($childKey)->update($postData);

    $notification = Notification::where('id', $n_id)->first();
    $notification->executed = 1;
    $notification->save();

}

function convert_to_lakh($amount = null)
{
    // return $amount;
    if ($amount == "") {
        return 0;
    }
    $val = $amount / 100000;
    $val = round($val, 2);
    return $val;
}

function get_notificaton_message($var)
{
    $message = array();
    $message[0] = "approved your data."; //data_approve
    $message[1] = "Disapproved your data."; //data_dis_approve
    $message[2] = "your report approved."; //report file approve
    $message[3] = "Your report file disapprved."; //report file dis_approve
    $message[4] = "Recommended for Your data acquisition"; //recommend data commend
    $message[5] = "You have got to received another filed data "; //recommendation message for DTL
    $message[6] = "Your field data has been recommended by deputy team lead."; //recommendation message for ARE
    $message[7] = "give a recommendation of this data."; //recommendation message  for all

    return $message[$var];
}

if (!function_exists('dateFormatter')) {
    /**
     * Format DateTime into Readable Date Format
     * @param $dateTime
     * @return string
     */
    function dateFormatter($dateTime): string
    {
        return Carbon::parse($dateTime)->format('d M Y');
    }
}

if (!function_exists('dateTimeFormatter')) {
    /**
     * Readable DateTime Format
     * @param $dateTime
     * @return string
     */
    function dateTimeFormatter($dateTime): string
    {
        return Carbon::parse($dateTime)->format('d M Y H:i');
    }
}

if (!function_exists('getDataAcquisitionStatus')) {
    /**
     * Get Acquisition Status
     * @param $acquisitionStatus
     * @return string
     */
    function getDataAcquisitionStatus($acquisitionStatus): string
    {
        if ($acquisitionStatus == 0) {
            $acquisitionStatusTitle = "Pending";
        } elseif ($acquisitionStatus == 1) {
            $acquisitionStatusTitle = "Approve By DTL Pending For TL";
        } elseif ($acquisitionStatus == 2 && (Auth::user()->role == 1 || Auth::user()->role == 6)) {
            $acquisitionStatusTitle = "Recommended";
        } else {
            $acquisitionStatusTitle = "Approved By TL";
        }
        return $acquisitionStatusTitle;
    }
}

if (!function_exists('getLimitedText')) {
    /**
     * Get 20 Character Limited Text
     * @param $text
     * @return string
     */
    function getLimitedText($text): string
    {
        return Str::limit($text, 30) ?? "-";
    }
}
