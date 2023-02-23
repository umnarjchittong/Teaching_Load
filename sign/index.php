<?php
require_once('../core.php');
require_once('../plugins/nusoap.php');

if (isset($_GET["p"]) && $_GET["p"] = "signout") {
    $_SESSION["admin"] = NULL;
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    header("location:../home/");
}

// * Setup the initial config
// $WebToken = "a74851c5ea7c4a9da3a3d25f3f0d75da"; // dev mode
$WebToken = "f7ae0397dd3043f08d0d93e789623a0a"; // launch mode
$AuthPath = "https://passport.mju.ac.th?W=" . $WebToken;
$SignInSuccess_URL = "../admin/";
$SignInFailure_URL = "../home/";

// * Check for request parameter
if (empty($_REQUEST["T"])) {
    // * If no parameter to the sign in form
    echo "<meta http-equiv='refresh' content='0; URL=$AuthPath'>";
} else {
    // * If I get a parameter, Set the parameter get the PID    
    $SoapClient = new nusoap_client('https://passport.mju.ac.th/login.asmx?wsdl', true);
    $response = $SoapClient->call('CitizenID', array('WebsiteToken' => $WebToken, 'LoginToken' => $_GET["T"]));
    if ($response["CitizenIDResult"]) {
        $pid = $response["CitizenIDResult"];
    } else {
        echo "<meta http-equiv='refresh' content='0; URL=$AuthPath'>";
    }

    if ($pid) {
        // * Using PID get the API information
        // echo "pid: " . $pid;
        $MJU_API = new MJU_API();
        $API_URL = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/" . $pid;
        $api_array = $MJU_API->GetAPI_array($API_URL)[0];
        if ($api_array["citizenId"] == "3500700238956") {
            $auth_lv = 9;
            $homepage = "index.php";
        } elseif ($api_array["citizenId"] == "3500600174174") { // teaching officer
            $auth_lv = 7;
            $homepage = "course.php";
        } elseif ($api_array["citizenId"] == "3509900264894") { // dean
            $auth_lv = 5;
            $homepage = "board.php";
        } elseif ($api_array["citizenId"] == "3501300659751") { // board punravee
            $auth_lv = 5;
            $homepage = "board.php";
        } else {
            $auth_lv = 3;
            $homepage = "teacher.php";
        }
        if (($api_array["facultyId"] != '21000' || $api_array["positionTypeId"] != "ก") && $auth_lv < 3) {
            echo "no fact";
            die();
        } else {
            // * view api data
            // print_r($api_array);
        }
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
            "homepage" => $homepage,
            "auth_lv" => $auth_lv
        );

        if (isset($auth_lv) && $auth_lv > 0 && $_SESSION["admin"]) {
            // echo "you have authentication level data is: ";
            // print_r($_SESSION["admin"]);
            // header("location:index.html");
            // echo '<meta http-equiv="refresh" content="0;url=../admin/' . $_SESSION["admin"]["homepage"] . '">';
            echo '<meta http-equiv="refresh" content="0;url=../admin/">';
        } else {
            echo "you have no authorize";
            echo '<meta http-equiv="refresh" content="5;url=https://faed.mju.ac.th/teachingload/e401.php?err=ท่านไม่มีสิทธิ์ใช้ระบบนี้">';
        }
    } else {
        echo "your info is not founded";
        echo '<meta http-equiv="refresh" content="5;url=https://faed.mju.ac.th/teachingload/e401.php?err=ระบบไม่พบข้อมูลของท่าน โปรดติดต่อฝ่ายไอที umnarj@mju.ac.th">';
    }
}
