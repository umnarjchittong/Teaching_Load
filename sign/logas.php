<?php
require_once('../core.php');
require_once('../plugins/nusoap.php');


// * Setup the initial config
$SignInSuccess_URL = "../admin/";
$SignInFailure_URL = "../";

// * Check for request parameter    
$logAs = $_GET["logAs"];
if ($logAs) {
    // * Using PID get the API information
    $MJU_API = new MJU_API();
    $API_URL = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
    $auth_lv = 3;
    switch ($logAs) {
            // * Log as authentication Level
        case "admin":
            $API_URL .= "3500700238956";
            $auth_lv = 9;
            break;
        case "officer":
            $API_URL .= "3500600174174"; // warachet
            $auth_lv = 7;
            break;
        case "dean":
            $API_URL .= "3509900264894"; // chokanan
            $auth_lv = 5;
            break;
        case "board":

            $API_URL .= "3501300659751";
            $auth_lv = 5;
            break;

            // * Log as Teacher
        case "augcharee":
            $API_URL .= "3310700896700";
            break;
        case "kittipong":
            $API_URL .= "3609700307696";
            break;
        case "nikorn":
            $API_URL .= "3501400408130";
            break;
        case "panawat":
            $API_URL .= "3501900170116";
            break;
        case "parinya":
            $API_URL .= "3580300037805";
            break;
        case "porntip":
            $API_URL .= "3401200159781";
            break;
        case "supanut":
            $API_URL .= "1501490000317";
            break;
        case "tanwutta":
            $API_URL .= "3102002277510";
            break;
        case "wittaya":
            $API_URL .= "3501300427515";
            break;
        case "wuttikan":
            $API_URL .= "3501200164334";
            break;
        case "yaowanit":
            $API_URL .= "3469900146698";
            break;
        case "yuttapoom":
            $API_URL .= "3149900340012";
            break;

        default:
            die("not right");
            break;
    }
    $api_array = $MJU_API->GetAPI_array($API_URL)[0];
    $fnc = new database();
    $_SESSION["admin"] = array(
        "citizenId" => $api_array["citizenId"],
        "titlePosition" => $fnc->gen_titlePosition_short($api_array["titlePosition"]),
        "firstName" => $api_array["firstName"],
        "lastName" => $api_array["lastName"],
        "firstName_en" => $api_array["fistNameEn"],
        "lastName_en" => $api_array["lastNameEn"],
        "positionTypeId" => $api_array["positionTypeId"],
        "department" => $fnc->get_db_col("SELECT `teaching_load_department` FROM `teaching_load` WHERE `teaching_load_citizenid`= '" . $api_array["citizenId"] . "' limit 1"),
        // "semester" => 1,
        // "edu_year" => (date("Y") + 543),
        // "homepage" => $homepage,
        "auth_lv" => $auth_lv
    );

    if (isset($auth_lv) && $auth_lv > 0 && $_SESSION["admin"]) {
        // echo "you have authentication level data is: ";
        // print_r($_SESSION["admin"]);
        // header("location:index.html");
        // $fnc->debug_console("admin", $_SESSION["admin"]);
        // echo '<meta http-equiv="refresh" content="1;url=' . $SignInSuccess_URL . '">';
        // echo '<meta http-equiv="refresh" content="0;url=../admin/' . $_SESSION["admin"]["homepage"] . '">';
        echo '<meta http-equiv="refresh" content="0;url=../admin/">';
    } else {
        echo "you have no authorize";
        // echo '<meta http-equiv="refresh" content="0;url=https://faed.mju.ac.th/ddm/e401.php?err=ท่านไม่มีสิทธิ์ใช้ระบบนี้">';
    }
} else {
    echo "your info is not founded";
    // echo '<meta http-equiv="refresh" content="0;url=https://faed.mju.ac.th/ddm/e401.php?err=ระบบไม่พบข้อมูลของท่าน โปรดติดต่อฝ่ายไอที umnarj@mju.ac.th">';
}
