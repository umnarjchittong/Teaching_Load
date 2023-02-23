<!doctype html>
<html lang="en">
<?php
include("core.php");
$fnc = new database;

function cap_append()
{
    global $fnc;
    // $course_info = $fnc->course_info_extract($_POST["course"]);    
    if (strpos($_POST["course"], chr(9))) {
        $course_info = explode(chr(9), $_POST["course"], 2);
    } else {
        $course_info = explode(" ", $_POST["course"], 2);
    }
    // print_r($course_info);
    // die();
    if (count($course_info) != 2) {
        echo "Course Name arr Wrong Formating, Please Check and Try Again.";
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/'>";
        echo "1<br>";
        die();
    }
    $sql = "SELECT `course_id` FROM `course` WHERE `course_code_th` = '" . $course_info[0] . "' AND `course_name_th` = '" . $course_info[1] . "'";
    $course_id = $fnc->get_db_col($sql);
    if (empty($course_id)) {
        if (isset($_POST["course_credit"])) {
            $sql = "INSERT INTO `course` (`course_code_th`, `course_name_th`, `course_credit`, `course_lec`, `course_lab`, `course_self`, `course_lec_hrs`, `course_lab_hrs`, `course_self_hrs`, `course_status`, `course_editor`, `course_lastupdate`) VALUES ('" . $course_info[0] . "', '" . $course_info[1] . "', " . $_POST["course_credit"] . ", " . $_POST["course_lec"] . ", " . $_POST["course_lab"] . ", " . $_POST["course_self"] . ", 15, 15, 0, 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        } else {
            $sql = "INSERT INTO `course` (`course_code_th`, `course_name_th`, `course_lec_hrs`, `course_lab_hrs`, `course_self_hrs`, `course_status`, `course_editor`, `course_lastupdate`) VALUES ('" . $course_info[0] . "', '" . $course_info[1] . "', '15', '15', '0', 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        }
        $fnc->sql_execute($sql);

        $course_id = $fnc->get_last_id("course", "course_id");
    }

    // echo "<hr>" . "notes: " . $notes . "<br>";
    if (isset($_POST["fst"]) && $_POST["fst"] == "capupdate") {
        // update course info
        $sql = "UPDATE `course` SET `course_code_th`='" . $course_info[0] . "',`course_name_th`='" . $course_info[1] . "',`course_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`course_lastupdate`=current_timestamp() WHERE  `course_id` = " . $_POST["course_id"];
        $fnc->sql_execute($sql);
        // update course_active_primary
        $sql = "UPDATE `course_active_primary` SET `cap_semester`='" . $_POST["semester"] . "',`cap_year`='" . $_POST["edu_year"] . "',`course_id`='" . $course_id . "',`cap_citizenid`='" . $_POST["teacher"] . "', `cap_status`='enable',`cap_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?semester=" . $_POST["semester"] . "&edu_year=" . $_POST["edu_year"] . "'>";
    }
    if (isset($_POST["fst"]) && $_POST["fst"] == "capappend") {
        $sql = "SELECT cap_id FROM course_active_primary WHERE cap_semester = " . $_POST["semester"] . " AND cap_year LIKE '" . $_POST["edu_year"] . "' AND course_id = " . $course_id . " AND cap_citizenid LIKE '" . $_POST["teacher"] . "'";
        $cnt = $fnc->get_db_array($sql);
        if (!empty($cnt)) {
            echo '<div class="container text-center h-2 text-danger mt-5 p-5"><div class="alert alert-danger" role="alert"><strong>Course Already Exists!</strong><br><br>รายวิชา ' . $course_info[0] . ' ' . $course_info[1] . ' ปีการศึกษา ' . $_POST["semester"] . '/' . $_POST["edu_year"] . ' ได้ถูกเปิดไว้ก่อนแล้ว.<br><br><a href="admin/?p=capadd" class="alert-link">ตรวจสอบข้อมูลและลองใหม่อีกครั้ง...</a></div></div>';
            // echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=capadd'>";
            die();
        }
        // if (is_null($notes)) {
        $sql = "INSERT INTO course_active_primary (cap_semester, cap_year, cap_department, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES (" . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', '" . $_POST["department"] . "', " . $course_id . ", '" . $_POST["teacher"] . "', 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        // } else {
        // $sql = "INSERT INTO course_active_primary (cap_notes, cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
        // VALUES ('" . $notes . "', " . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        // }
        // die($sql);
        $fnc->sql_execute($sql);
        die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?semester=" . $_POST["semester"] . "&edu_year=" . $_POST["edu_year"] . "&dept=" . $_POST["department"] . "'>");
    }
    // $fnc->debug_console("sql: " . $sql);
    // echo '</div>';
    die();
}

function cap_append_ok()
{
    global $fnc;
    $course_info = $fnc->course_info_extract($_POST["course"]);
    $sql = "SELECT cap_id FROM course_active_primary WHERE cap_semester = " . $_POST["semester"] . " AND cap_year LIKE '" . $_POST["edu_year"] . "' AND course_id = " . $course_info["id"] . " AND cap_citizenid LIKE '" . $_POST["teacher"] . "'";
    // $fnc->debug_console("sql find existing data: ", $sql);
    $cnt = $fnc->get_db_array($sql);
    if (!empty($cnt)) {
        $cnt = count($fnc->get_db_array($sql));
    }

    // echo '<div class="container border-bot" . $_SESSION["admin"]["firstName_en"] . " mb-4">';
    if ($cnt > 0) {
        $notes = $fnc->cap_dupplicate_notes[0] . (intval($cnt) + 1) . $fnc->cap_dupplicate_notes[1];
    } else {
        $notes = NULL;
    }
    // echo "<hr>" . "notes: " . $notes . "<br>";
    if (isset($_POST["fst"]) && $_POST["fst"] == "capupdate") {
        $sql = "UPDATE `course_active_primary` SET `cap_semester`='" . $_POST["semester"] . "',`cap_year`='" . $_POST["edu_year"] . "',`course_id`='" . $course_info["id"] . "',`cap_citizenid`='" . $_POST["teacher"] . "', `cap_status`='enable',`cap_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/'>";
    }
    if (isset($_POST["fst"]) && $_POST["fst"] == "capappend") {
        if (is_null($notes)) {
            $sql = "INSERT INTO course_active_primary (cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES (" . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        } else {
            $sql = "INSERT INTO course_active_primary (cap_notes, cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES ('" . $notes . "', " . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
        }
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/'>";
    }
    // $fnc->debug_console("sql: " . $sql);
    // echo '</div>';
    die();
}

function cas_append()
{
    global $fnc;
    $sql = "INSERT INTO course_active_secondary (cap_id, cas_citizenid, cas_lecture_hours, cas_lab_hours, cas_self_hours, cas_status, cas_editor, cas_lastupdate) 
                    VALUES (" . $_POST["cap_id"] . ", '" . $_POST["teacher"] . "', 0, 0, 0, 'enable', '" . $_SESSION["admin"]["firstName_en"] . "', current_timestamp())";
    $fnc->debug_console("sql append ta: ", $sql);
    $fnc->sql_execute($sql);
    // * check if studio course the secondary teacher get 100% of teaching hours
    $sql = "SELECT cap_lecture_hours, cap_lab_hours, cap_self_hours FROM v_cap2 WHERE course_studio = 'true' AND cap_id = " . $_POST["cap_id"];
    $row = $fnc->get_db_row($sql);
    if (!empty($row)) {
        $sql = "UPDATE course_active_secondary SET cas_lecture_hours = '" . $row["cap_lecture_hours"] . "', cas_lab_hours = '" . $row["cap_lecture_hours"] . "' WHERE cap_id = " . $_POST["cap_id"];
        $fnc->sql_execute($sql);
        $fnc->debug_console("sql hrs ta: ", $sql);
    }
    die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=courseview&cap_cid=" . $_POST["course_id"] . "&cap_id=" . $_POST["cap_id"] . "&ta=form'>");
    // }
    // echo $sql;
    // echo '</div>';
    die();
}

function course_update()
{
    global $fnc;
    $sql = "UPDATE `course` SET `course_code_th`='" . $_POST["course_code_th"] . "',`course_code_en`='" . $_POST["course_code_en"] . "',`course_name_th`='" . $_POST["course_name_th"] . "',`course_name_en`='" . $_POST["course_name_en"] . "',`course_credit`=" . $_POST["course_credit"] . ",`course_lec`=" . $_POST["course_lec"] . ",`course_lab`=" . $_POST["course_lab"] . ",`course_self`=" . $_POST["course_self"] . ",`course_lec_hrs`=" . $_POST["course_lec_hrs"] . ",`course_lab_hrs`=" . $_POST["course_lab_hrs"] . ",`course_self_hrs`=" . $_POST["course_self_hrs"] . ",`course_status`='" . $_POST["course_status"] . "',`course_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`course_lastupdate`=current_timestamp() WHERE `course_id` = " . $_POST["course_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=courseview&cap_cid=" . $_POST["course_id"] . "&cap_id=" . $_POST["cap_id"] . "'>");
}

function course_studio_assign($course, $status = '')
{
    global $fnc;
    $sql = "";
    foreach ($course as $row) {
        $sql .= "UPDATE course SET course_studio = '" . $status . "', course_editor = '" . $_SESSION["admin"]["firstName_en"] . "', course_lastupdate = CURRENT_TIMESTAMP WHERE course_id = " . $row . "; ";
    }
    // echo($sql);
    $fnc->sql_execute_multi($sql);
}

function course_studio_hrs_update()
{
    global $fnc;
    $sql_update = "";
    $sql = "SELECT course_code_th FROM course WHERE course_studio = 'studio' AND course_status = 'enable' ORDER BY course_code_th";
    $studio_course = $fnc->get_db_array($sql);
    $sql_update = "";
    foreach ($studio_course as $stucourse) {
        $sql = "Select course_active_primary.cap_id, course_active_primary.cap_semester, course_active_primary.cap_year, course.course_code_th, course.course_name_th, course_active_primary.cap_citizenid, 
                        course.course_lec, course.course_lab_hrs, course_active_primary.cap_lecture_hours, course.course_lab, course.course_lec_hrs, course_active_primary.cap_lab_hours, course.course_self From course_active_primary Inner Join course On course.course_id = course_active_primary.course_id 
                        Where course_active_primary.cap_semester = " . $_SESSION["admin"]["semester"] . " And course_active_primary.cap_year = '" . $_SESSION["admin"]["edu_year"] . "' And course.course_code_th = '" . $stucourse["course_code_th"] . "'";
        $row = $fnc->get_db_row($sql);
        // print_r($row);
        $sql_update .= "UPDATE course_active_primary SET cap_lecture_hours = '" . ($row["course_lec"] * $row["course_lec_hrs"]) . "', cap_lab_hours = '" . ($row["course_lab"] * $row["course_lab_hrs"]) . "', cap_lastupdate = CURRENT_TIMESTAMP WHERE cap_id = " . $row["cap_id"] . "; ";
        $sql_update .= "UPDATE course_active_secondary SET cas_lecture_hours = '" . ($row["course_lec"] * $row["course_lec_hrs"]) . "', cas_lab_hours = '" . ($row["course_lab"] * $row["course_lab_hrs"]) . "', cas_lastupdate = CURRENT_TIMESTAMP WHERE cap_id = " . $row["cap_id"] . "; ";
    }
    // echo($sql);
    $fnc->sql_execute_multi($sql_update);
}

function course_zero_hrs_update()
{
    global $fnc;
    $sql_update = "";
    $studio_course = $fnc->get_db_array("SELECT cap_id FROM course_active_primary INNER JOIN course ON course_active_primary.course_id = course.course_id WHERE course_studio = 'zero'  AND course_status = 'enable'");
    $fnc->debug_console("studio_course sql: ", $studio_course);
    foreach ($studio_course as $stucourse) {
        $sql_update .= "UPDATE course_active_primary SET cap_lecture_hours='0', cap_lab_hours='0', cap_lastupdate = CURRENT_TIMESTAMP WHERE course_id = " . $stucourse["cap_id"] . "; ";
        $sql_update .= "UPDATE course_active_secondary SET cas_lecture_hours='0', cas_lab_hours='0', cas_lastupdate = CURRENT_TIMESTAMP WHERE cap_id = " . $stucourse["cap_id"] . "; ";
    }
    // echo($sql);
    $fnc->sql_execute_multi($sql_update);
}

function teacher_department_assign($teacher, $status)
{
    global $fnc;
    $sql = "";
    foreach ($teacher as $row) {
        // $sql .= "UPDATE course SET course_studio = '" . $status . "', course_editor = '" . $_SESSION["admin"]["firstName_en"] . "', course_lastupdate = CURRENT_TIMESTAMP WHERE course_id = " . $row . "; ";
        $sql .= "UPDATE teacher SET department = '" . $status . "' WHERE citizenId = '" . $row . "'; ";
    }
    // die($sql);
    $fnc->sql_execute_multi($sql);
}

?>

<head>
    <title>TeachingLoad Mgt</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
</head>

<body style="font-size: 0.7em">
    <div class="container my-5 p-5">
        <div class="col-6 mx-auto my-5 p-5 text-center">
            <img src="images/loading.gif" width="50px;">
        </div>
    </div>

    <?php

    if (isset($_POST["fst"]) && $_POST["fst"] == "setting_update") {
        $sql = "UPDATE settings SET setting_due_date = '" . $_POST["setting_due_date"] . "' WHERE setting_id = " . $_POST["sid"];
        // die($sql);
        $fnc->sql_execute($sql);
        die("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh) . "; URL=admin/setting.php?p=editable'>");
    }

    if (isset($_POST["fst"]) && $_POST["fst"] == "teacherExtAppend") {
        $sql = "INSERT INTO teacher_ext (teacher_ext_citizenid, teacher_ext_titleName, teacher_ext_titlePosition, teacher_ext_firstName, teacher_ext_lastName, teacher_ext_status, teacher_ext_lastupdate) 
        VALUES ('" . $_POST["citizenid"] . "', '" . $_POST["titleName"] . "', '" . $_POST["titlePosition"] . "', '" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', 'enable', current_timestamp())";
        // die($sql);
        $fnc->sql_execute($sql);
        die("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh) . "; URL=admin/setting.php?p=extTeacher'>");
    }

    if (isset($_POST["fst"]) && $_POST["fst"] == "teacherExtDelete") {
        $sql = "SELECT COUNT(cap_id) AS cnt_id FROM course_active_secondary WHERE cas_citizenid = '" . $_POST["teacher"] . "'";
        if ($fnc->get_db_col > 0) {
            $sql = "DELETE FROM teacher_ext WHERE teacher_ext_citizenid = '" . $_POST["teacher"] . "'";
            die($sql);
            $fnc->sql_execute($sql);
            die("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh) . "; URL=admin/setting.php?p=extTeacher'>");
        } else {
            die("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh) . "; URL=admin/setting.php?p=extTeacher&alert=warning&title=ลบไม่สำเร็จ&msg=อาจารย์พิเศษที่ท่านต้องการลบ ยังมีภาระงานสอนอยู่ โปรดตรวจสอบ'>");
        }
    }

    if (isset($_POST["fst"]) && $_POST["fst"] == "departmentAssign") {
        if (isset($_POST["btn_department"])) {
            // echo "teacher<hr>";
            if (isset($_POST["teacherA"]) && $_POST["deptA"] != $_POST["deptB"]) {
                // print_r($_POST["teacherA"]);
                teacher_department_assign($_POST["teacherA"], $_POST["deptB"]);
                // } else {
                //     echo "no selected go back";
            }
            echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 1) . "; URL=admin/setting.php?p=curriculumTeacher&deptA=" . $_POST["deptA"] . "&deptB=" . $_POST["deptB"] . "'>");
        }
    }

    if (isset($_POST["fst"]) && $_POST["fst"] == "courseStudioAssign") {
        if (isset($_POST["btn_studio"])) {
            // echo "studio<hr>";
            if (isset($_POST["course"])) {
                // print_r($_POST["course"]);
                course_studio_assign($_POST["course"], "studio");
                course_studio_hrs_update();
            } else {
                echo "no selected go back";
            }
            echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 2) . "; URL=admin/setting.php?p=courseStudio'>");
        }
        if (isset($_POST["btn_general"])) {
            // echo "general<hr>";
            if (isset($_POST["course_studio"])) {
                // print_r($_POST["course"]);
                course_studio_assign($_POST["course_studio"], "");
                course_studio_hrs_update();
            } else {
                echo "no selected go back";
            }
            echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 2) . "; URL=admin/setting.php?p=courseStudio'>");
        }
        if (isset($_POST["btn_zero"])) {
            // echo "general<hr>";
            if (isset($_POST["course"])) {
                // print_r($_POST["course"]);
                course_studio_assign($_POST["course"], "zero");
                course_zero_hrs_update();
            } else {
                echo "no selected go back";
            }
            echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 2) . "; URL=admin/setting.php?p=courseZero'>");
        }
        if (isset($_POST["btn_general2"])) {
            // echo "general<hr>";
            if (isset($_POST["course_zero"])) {
                // print_r($_POST["course"]);
                course_studio_assign($_POST["course_zero"], "");
                course_zero_hrs_update();
            } else {
                echo "no selected go back";
            }
            echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 2) . "; URL=admin/setting.php?p=courseZero'>");
        }
    }

    if (isset($_GET["p"]) && isset($_GET["qst"]) && $_GET["qst"] == "dbexcutes" && isset($_GET["parameter"])) {
        $fnc->sql_execute_multi(json_decode($_SESSION["admin"]["setting"][$_GET["parameter"]]));
        echo json_decode($_SESSION["admin"]["setting"][$_GET["parameter"]]);
        echo ("<meta http-equiv='refresh' content='" . ($fnc->system_meta_refresh + 3) . "; URL=admin/setting.php?p=" . $_GET["p"] . "'>");
    }

    if (isset($_POST["submit"]) && isset($_POST["course"]) && isset($_POST["teacher"]) && isset($_POST["fst"])) {
        cap_append();
    }

    if (isset($_POST["ta_submit"]) && isset($_POST["course_id"]) && isset($_POST["cap_id"]) && isset($_POST["fst"]) &&  $_POST["fst"] == "casappend") {
        cas_append();
    }

    if (isset($_POST["courseupdate"]) && isset($_POST["fst"]) && $_POST["fst"] == "courseupdate" && isset($_POST["course_id"]) && isset($_POST["cap_id"])) {
        course_update($_POST["course_id"]);
    }



    if (isset($_GET["act"]) && $_GET["act"] == "capdelete" && isset($_GET["cap_id"]) && isset($_GET["p"]) && $_GET["p"] == "course") {
        $sql = "UPDATE `course_active_primary` SET `cap_status`='delete',`cap_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`cap_lastupdate`=CURRENT_TIMESTAMP() WHERE `cap_id` = " . $_GET['cap_id'];
        // $fnc->sql_execute($sql);
        // echo $sql;
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/'>";
    }

    if (isset($_GET["act"]) && $_GET["act"] == "casdelete" && isset($_GET["cas_id"]) && isset($_GET["cap_cid"])) {
        $sql = "UPDATE `course_active_secondary` SET `cas_status`='delete', `cas_editor`='" . $_SESSION["admin"]["firstName_en"] . "',`cas_lastupdate`=current_timestamp() WHERE `cas_id` = " . $_GET['cas_id'];
        // die($sql);
        $fnc->sql_execute($sql);
        die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=courseview&cap_cid=" . $_GET["cap_cid"] . "&cap_id=" . $_GET["cap_id"] . "&alert=success&title=สำเร็จ&msg=นำรายชื่อผู้สอนร่วมออกเรียบร้อย.'>");
    }

    if (isset($_GET["act"]) && isset($_POST["fst"]) && isset($_POST["cap_cid"])) {
        if (!isset($_POST["hrs_lecture"])) {
            $_POST["hrs_lecture"] = 0;
        }
        if (!isset($_POST["hrs_laboratory"])) {
            $_POST["hrs_laboratory"] = 0;
        }
        if (isset($_POST["cas_id"]) && $_POST["fst"] == "casHrsUpdate") {
            $sql = "UPDATE `course_active_secondary` SET `cas_lecture_hours`=" . $_POST["hrs_lecture"] . ",`cas_lab_hours`=" . $_POST["hrs_laboratory"] . ",`cas_lastupdate`=current_timestamp() WHERE `cas_id` = " . $_POST["cas_id"];
            $fnc->sql_execute($sql);
            die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=courseview&cap_cid=" . $_POST["cap_cid"] . "&cap_id=" . $_POST["cap_id"] . "'>");
            // echo '<hr class="mt-4"><a href="cap.php?p=courseview&cap_cid=' . $_POST["cap_cid"] . '&cap_id=' . $_POST["cap_id"] . '" class="btn btn-success h4 px-4 text-uppercase">Update completed please NEXT</a><hr class="mb-4">';
        } elseif (isset($_POST["cap_id"]) && $_POST["fst"] == "capHrsUpdate") {
            $sql = "UPDATE `course_active_primary` SET `cap_lecture_hours`=" . $_POST["hrs_lecture"] . ",`cap_lab_hours`=" . $_POST["hrs_laboratory"] . ",`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
            $fnc->sql_execute($sql);
            // die($sql);
            die("<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=admin/?p=courseview&cap_cid=" . $_POST["cap_cid"] . "&cap_id=" . $_POST["cap_id"] . "'>");
            // echo '<hr class="mt-4"><a href="cap.php?p=courseview&cap_cid=' . $_POST["cap_cid"] . '&cap_id=' . $_POST["cap_id"] . '" class="btn btn-success h4 px-4 text-uppercase">Update completed please NEXT</a><hr class="mb-4">';
        }
        // echo $sql;
        die();
        // echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $fnc->get_last_id("course_active_primary", "cap_id") . "'>";

    }


    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>