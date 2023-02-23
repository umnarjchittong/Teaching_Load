<!doctype html>
<?php
require('../vendor/autoload.php');
include("../core.php");
$fnc = new Web();
if (empty($_SESSION["admin"])) {
    echo '<meta http-equiv="refresh" content="1;url=../sign/">';
    die();
} else {
    $fnc->debug_console("admin ", $_SESSION["admin"]);
    // if (!$_SESSION["admin"] && $_SESSION["admin"]["homepage"] != $fnc->get_url_filename()) {
    // echo '<meta http-equiv="refresh" content="0;url=../admin/' . $_SESSION["admin"]["homepage"] . '?p=welcome">';
    // }
}

$MJU_API = new MJU_API();
$api_person_faculty = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
$api_person = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";

// $semester = NULL;
// $edu_year = NULL;
// if (isset($_GET["semester"]) && $_GET["semester"] != "") {
//     $semester = $_GET["semester"];
// }
// if (isset($_GET["edu_year"]) && $_GET["edu_year"] != "") {
//     $edu_year = $_GET["edu_year"];
// }
// if (isset($_GET["cap_uid"]) && strlen($_GET["cap_uid"]) == 13) {
//     $uid = $_GET["cap_uid"];
// } else {
//     $uid = $_SESSION["admin"]["citizenId"];
// }
// if (!$semester || !$edu_year) {
//     $sql = "Select coap.cap_semester, coap.cap_year From course_active_primary coap Inner Join course_active_secondary coas On coas.cap_id = coap.cap_id Where (coap.cap_citizenid = '" . $uid . "') Or (coas.cas_citizenid = '" . $uid . "') Order By coap.cap_year Desc, coap.cap_semester Desc LIMIT 1";
//     $last_cap = $fnc->get_db_row($sql);
//     if (!empty($last_cap)) {
//         $semester = $last_cap["cap_semester"];
//         $edu_year = $last_cap["cap_year"];
//     } else {
//         $semester = 1;
//         $edu_year = date("Y") + 543;
//     }
// }
?>
<html lang="en">

<head>
    <title>Teaching Load</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/twbs/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"> -->

    <link rel="stylesheet" href="../style.css">
    <style>
        a .menu_active {
            color: #c86840;
        }
    </style>

</head>

<body>

    <header>
        <!-- Fixed navbar -->
        <?php include "top_menu.php"; ?>
        <div class="" style="padding-top: 3.75em;"></div>
    </header>
    <?php if ($_SESSION["admin"]["auth_lv"] <= 7) { ?>
        <div class="container h6 text-end"><?= '<span class="text-warning">Editor:</span> ' . $_SESSION["admin"]["titlePosition"] . $_SESSION["admin"]["firstName"] . "&nbsp;&nbsp;" . $_SESSION["admin"]["lastName"] ?></div>
    <?php } ?>

    <?php

    if (isset($_GET["p"]) && $_GET["p"] != "") {
        switch ($_GET["p"]) {
            case "capadd":
                $fnc->cap_form();
                break;
            case "capedit":
                if (isset($_GET["cap_id"])) {
                    $fnc->cap_form();
                }
                break;
            case "courseview":
                if (isset($_GET["cap_cid"]) && isset($_GET["cap_id"])) {
                    $fnc->view_course_primary();
                }
                break;
            case "courseedit":
                if (isset($_GET["cap_cid"]) && isset($_GET["cap_id"])) {
                    // view_course_primary();
                    $fnc->edit_course_primary($_GET["cap_cid"], $_GET["cap_id"]);
                }
                break;
            case "userview":
                if (isset($_GET["cap_uid"])) {
                    $fnc->view_user($_GET["cap_uid"], $semester, $edu_year);
                } else {
                    $fnc->view_user($_SESSION["admin"]["citizenId"], $semester, $edu_year);
                }
                break;
            case "teacherreport":
                // echo "<h1>umnarj</h1>";
                $fnc->teacher_report($semester, $edu_year);
                break;
            case "courseregist":
                $fnc->cap_form();
                break;
            case "openCourseMgt":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "curriculumTeacher":
                $fnc->curriculum_teacher_form();
                break;
            case "externalreport":
                // $fnc->teacher_report($semester, $edu_year);
                $fnc->external_report($semester, $edu_year);
                break;
            case "curriculumreport":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            case "curriculumReportAR":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            case "curriculumReportLA":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            case "curriculumReportLT":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            case "curriculumReportMURP":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            case "curriculumReportAV":
                $fnc->curriculum_report($semester, $edu_year);
                break;
            // case "welcome":
                // $fnc->cap_form();
                // $fnc->cap_table($semester, $edu_year);
                // break;
            case "courseReport":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "CourseReportAR":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "CourseReportLA":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "CourseReportLT":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "CourseReportMURP":
                $fnc->cap_table($semester, $edu_year);
                break;
            case "CourseReportAV":
                $fnc->cap_table($semester, $edu_year);
                break;
        }
    } else {
        echo '<style>
        #mainmenu a {
            text-decoration: none; 
            font-size: 0.9em; 
            padding: 1.2em 0em;
            margin: 1.2em 0em;
        }
                </style>';

        echo '<div class="rounded text-muted p-5 col-10 mx-auto bg-secondary fs-6 fw-lighter"  style="margin-top: 2.2em;">';
        echo '<h3 class="text-warning mb-3">ระบบจัดการภาระงานสอนของบุคลากรสายวิชาการ</h3>';

        if (!empty($_SESSION["admin"]["department"])) {
            switch ($_SESSION["admin"]["department"]) {
                case "สถาปัตยกรรมศาสตร์":
                    $p_parameter = "AR";
                    break;
                case "ภูมิสถาปัตยกรรมศาสตร์":
                    $p_parameter = "LA";
                    break;
                case "เทคโนโลยีภูมิทัศน์":
                    $p_parameter = "LT";
                    break;
                case "การวางผังเมืองและสภาพแวดล้อม":
                    $p_parameter = "MURP";
                    break;
                case "การออกแบบและวางแผนสิ่งแวดล้อม":
                    $p_parameter = "AV";
                    break;
                default:
                    $p_parameter = "";
            }
        }

        if ($_SESSION["admin"]["auth_lv"] == 3 || $_SESSION["admin"]["auth_lv"] == 5) {
            echo '<div id="mainmenu" class="container text-light mt-4">';
            echo '  <div class="row row-cols-2 g-5">';
            echo '      <div class="col">';
            echo '          <a href="index.php?p=userview" class="btn btn-lg btn-success shadow px-4 w-100">ภาระงานสอนของฉัน</a>';
            // echo '<a href="index.php?p=courseReport&semester=' . $semester . '&edu_year=' . $edu_year . '" class="btn btn-lg btn-info shadow px-4 w-100">วิชาที่เปิดสอนในหลักสูตรทั้งคณะฯ</a>';
            if (!empty($p_parameter)) {
                echo '          <a href="index.php?p=curriculumReport' . $p_parameter . '&semester=' . $semester . '&edu_year=' . $edu_year . '" class="btn btn-lg btn-success shadow px-4 w-100">ภาระงานสอนในหลักสูตร' . $_SESSION["admin"]["department"] . '</a>';
            }
            echo '          <a href="index.php?p=teacherreport" class="btn btn-lg btn-success shadow px-4 w-100">ภาระงานสอนทั้งคณะฯ</a>';
            echo '      </div>';
            echo '      <div class="col">';
            if (!empty($p_parameter)) {
                echo '          <a href="course.php?p=CourseReport' . $p_parameter . '&semester=2&edu_year=2564" class="btn btn-lg btn-info shadow px-4 w-100">วิชาที่เปิดสอนในหลักสูตร' . $_SESSION["admin"]["department"] . '</a>';
            }
            echo '          <a href="index.php?p=courseReport&semester=' . $semester . '&edu_year=' . $edu_year . '" class="btn btn-lg btn-info shadow px-4 w-100">วิชาที่เปิดสอนในหลักสูตรทั้งคณะฯ</a>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        } elseif ($_SESSION["admin"]["auth_lv"] >= 7) {
            echo '<div id="mainmenu" class="container text-light mt-4">';
            echo '  <div class="row row-cols-2 g-5">';
            echo '      <div class="col">';
            // echo '          <a href="board.php?p=userview" class="btn btn-lg btn-success shadow px-4 w-100">ภาระงานสอนของฉัน</a>';
            // echo '<a href="index.php?p=courseReport&semester=' . $semester . '&edu_year=' . $edu_year . '" class="btn btn-lg btn-info shadow px-4 w-100">วิชาที่เปิดสอนในหลักสูตรทั้งคณะฯ</a>';            
            echo '          <a href="index.php?p=teacherreport" class="btn btn-lg btn-success shadow px-4 w-100">ภาระงานสอนทั้งคณะฯ</a>';
            echo '          <a href="setting.php?p=curriculumTeacher" class="btn btn-lg btn-success shadow px-4 w-100">จัดการอาจารย์ประจำหลักสูตร</a>';
            echo '          <a href="setting.php?p=extTeacher" class="btn btn-lg btn-success shadow px-4 w-100">จัดการอาจารย์พิเศษ</a>';
            echo '      </div>';
            echo '      <div class="col">';
            echo '          <a href="course.php?p=courseregist" class="btn btn-lg btn-info shadow px-4 w-100">ลงทะเบียนวิชา</a>';
            echo '          <a href="index.php?p=courseReport&semester=' . $semester . '&edu_year=' . $edu_year . '" class="btn btn-lg btn-info shadow px-4 w-100">วิชาที่เปิดสอนทั้งคณะฯ</a>';
            echo '          <a href="setting.php?p=courseStudio" class="btn btn-lg btn-info shadow px-4 w-100">จัดการรายวิชาสตูดิโอ</a>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }

        if ($_SESSION["admin"]["editable"] == "true") {
            echo '<div class="text-end text-light mt-3">* สิ้นสุดการแก้ไขภาระงานในวันที่ ';
            echo $fnc->get_date_semi_th($_SESSION["admin"]["editable_duedate"]);
            echo '</div>';
        } elseif ($_SESSION["admin"]["editable"] == "false") {
            echo '<div class="text-end text-light mt-3">* ระบบปิดการแก้ไขภาระงานแล้ว</div>';
        }

        echo '</div>';
    }

    ?>

    <!-- footer -->
    <div class="py-3"></div>
    <footer class="footer mt-auto py-2 bg-light">
        <div class="container text-center" style="font-size: 0.8em;">
            <span class="text-muted text-capitalize">ระบบบันทึกและรายงานภาระงานสอนอาจารย์<br>คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>
                last update: <?= date("M d, Y") ?></span>
        </div>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <?php include('../sweet_alert.php'); ?>
</body>

</html>