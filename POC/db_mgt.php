<!doctype html>
<html lang="en">
<?php
include("../core.php");
$fnc = new Web_Object;

function cap_append()
{
    global $fnc;
    // $course_info = $fnc->course_info_extract($_POST["course"]);
    $course_info = explode(" ", $_POST["course"]);
    if (count($course_info) != 2) {
        echo "Course Name arr Wrong Formating, Please Check and Try Again.";
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php'>";
        echo "1<br>";
        die();
    }
    $sql = "SELECT `course_id` FROM `course` WHERE `course_code_th` = '" . $course_info[0] . "' AND `course_name_th` = '" . $course_info[1] . "'";
    $course_id = $fnc->get_db_col($sql);
    if (empty($course_id)) {
        $sql = "INSERT INTO `course` (`course_code_th`, `course_name_th`, `course_lec_hrs`, `course_lab_hrs`, `course_self_hrs`, `course_status`, `course_editor`, `course_lastupdate`) VALUES ('" . $course_info[0] . "', '" . $course_info[1] . "', '15', '15', '0', 'enable', 'TOM', current_timestamp())";
        $fnc->sql_execute($sql);

        $course_id = $fnc->get_last_id("course", "course_id");
    }

    $sql = "SELECT cap_id FROM course_active_primary WHERE cap_semester = " . $_POST["semester"] . " AND cap_year LIKE '" . $_POST["edu_year"] . "' AND course_id = " . $course_id . " AND cap_citizenid LIKE '" . $_POST["teacher"] . "'";
    $cnt = $fnc->get_db_array($sql);
    if (!empty($cnt)) {
        echo "Already Exists";
    }
    // echo "<hr>" . "notes: " . $notes . "<br>";
    if (isset($_POST["fst"]) && $_POST["fst"] == "capupdate") {
        // update course info
        $sql = "UPDATE `course` SET `course_code_th`='" . $course_info[0] . "',`course_name_th`='" . $course_info[0] . "',`course_editor`='TOM',`course_lastupdate`=current_timestamp() WHERE  `course_id` = " . $_POST["course_id"];
        $fnc->sql_execute($sql);
        // update course_active_primary
        $sql = "UPDATE `course_active_primary` SET `cap_semester`='" . $_POST["semester"] . "',`cap_year`='" . $_POST["edu_year"] . "',`course_id`='" . $course_id . "',`cap_citizenid`='" . $_POST["teacher"] . "', `cap_status`='enable',`cap_editor`='TOM',`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php'>";
    }
    if (isset($_POST["fst"]) && $_POST["fst"] == "capappend") {
        // if (is_null($notes)) {
        $sql = "INSERT INTO course_active_primary (cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES (" . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_id . ", '" . $_POST["teacher"] . "', 'enable', 'TOM', current_timestamp())";
        // } else {
        // $sql = "INSERT INTO course_active_primary (cap_notes, cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
        // VALUES ('" . $notes . "', " . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', 'TOM', current_timestamp())";
        // }
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php'>";
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

    // echo '<div class="container border-bottom mb-4">';
    if ($cnt > 0) {
        $notes = $fnc->cap_dupplicate_notes[0] . (intval($cnt) + 1) . $fnc->cap_dupplicate_notes[1];
    } else {
        $notes = NULL;
    }
    // echo "<hr>" . "notes: " . $notes . "<br>";
    if (isset($_POST["fst"]) && $_POST["fst"] == "capupdate") {
        $sql = "UPDATE `course_active_primary` SET `cap_semester`='" . $_POST["semester"] . "',`cap_year`='" . $_POST["edu_year"] . "',`course_id`='" . $course_info["id"] . "',`cap_citizenid`='" . $_POST["teacher"] . "', `cap_status`='enable',`cap_editor`='TOM',`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php'>";
    }
    if (isset($_POST["fst"]) && $_POST["fst"] == "capappend") {
        if (is_null($notes)) {
            $sql = "INSERT INTO course_active_primary (cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES (" . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', 'TOM', current_timestamp())";
        } else {
            $sql = "INSERT INTO course_active_primary (cap_notes, cap_semester, cap_year, course_id, cap_citizenid, cap_status, cap_editor, cap_lastupdate) 
            VALUES ('" . $notes . "', " . $_POST["semester"] . ", '" . $_POST["edu_year"] . "', " . $course_info["id"] . ", '" . $_POST["teacher"] . "', 'enable', 'TOM', current_timestamp())";
        }
        $fnc->sql_execute($sql);
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php'>";
    }
    // $fnc->debug_console("sql: " . $sql);
    // echo '</div>';
    die();
}

function cas_append()
{
    global $fnc;
    $sql = "INSERT INTO course_active_secondary (cap_id, cas_citizenid, cas_lecture_hours, cas_lab_hours, cas_self_hours, cas_status, cas_editor, cas_lastupdate) 
                    VALUES (" . $_POST["cap_id"] . ", '" . $_POST["teacher"] . "', 0, 0, 0, 'enable', 'TOM', current_timestamp())";
    $fnc->debug_console("sql append ta: ", $sql);
    $fnc->sql_execute($sql);
    echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $_POST["course_id"] . "&cap_id=" . $_POST["cap_id"] . "&ta=form'>";
    // }
    // echo $sql;
    // echo '</div>';
    die();
}

function course_update()
{
    global $fnc;
    $sql = "UPDATE `course` SET `course_code_th`='" . $_POST["course_code_th"] . "',`course_code_en`='" . $_POST["course_code_en"] . "',`course_name_th`='" . $_POST["course_name_th"] . "',`course_name_en`='" . $_POST["course_name_en"] . "',`course_credit`=" . $_POST["course_credit"] . ",`course_lec`=" . $_POST["course_lec"] . ",`course_lab`=" . $_POST["course_lab"] . ",`course_self`=" . $_POST["course_self"] . ",`course_lec_hrs`=" . $_POST["course_lec_hrs"] . ",`course_lab_hrs`=" . $_POST["course_lab_hrs"] . ",`course_self_hrs`=" . $_POST["course_self_hrs"] . ",`course_status`='" . $_POST["course_status"] . "',`course_editor`='TOM',`course_lastupdate`=current_timestamp() WHERE `course_id` = " . $_POST["course_id"];
    // die($sql);
    $fnc->sql_execute($sql);
    echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $_POST["course_id"] . "&cap_id=" . $_POST["cap_id"] . "'>";
}
?>

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">
</head>

<body>
    <?php


    if (isset($_POST["submit"]) && isset($_POST["course"]) && isset($_POST["teacher"]) && isset($_POST["fst"])) {
        cap_append();
    }

    if (isset($_POST["ta_submit"]) && isset($_POST["course_id"]) && isset($_POST["cap_id"]) && isset($_POST["fst"]) &&  $_POST["fst"] == "casappend") {
        cas_append();
    }

    if (isset($_POST["courseupdate"]) && isset($_POST["fst"]) && $_POST["fst"] == "courseupdate" && isset($_POST["course_id"]) && isset($_POST["cap_id"])) {
        course_update($_POST["course_id"]);
    }



    if (isset($_GET["act"]) && $_GET["act"] == "casdelete" && isset($_GET["cas_id"]) && isset($_GET["cap_cid"])) {
        $sql = "UPDATE `course_active_secondary` SET `cas_status`='delete', `cas_editor`='TOM',`cas_lastupdate`=current_timestamp() WHERE `cas_id` = " . $_GET['cas_id'];
        $fnc->sql_execute($sql);
        // echo $sql;
        echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $_GET["cap_cid"] . "&cap_id=" . $_GET["cap_id"] . "'>";
    }

    if (isset($_GET["act"]) && isset($_POST["fst"]) && isset($_POST["cap_cid"])) {
        echo "in";
        // if (isset($_POST["cap_id"]) && $_POST["cap_id"] >= 1) {
        if (isset($_POST["cas_id"]) && $_POST["fst"] == "casHrsUpdate") {
            $sql = "UPDATE `course_active_secondary` SET `cas_lecture_hours`=" . $_POST["hrs_lecture"] . ",`cas_lab_hours`=" . $_POST["hrs_laboratory"] . ",`cas_lastupdate`=current_timestamp() WHERE `cas_id` = " . $_POST["cas_id"];
            $fnc->sql_execute($sql);
            echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $_POST["cap_cid"] . "&cap_id=" . $_POST["cap_id"] . "'>";
            // echo '<hr class="mt-4"><a href="cap.php?p=courseview&cap_cid=' . $_POST["cap_cid"] . '&cap_id=' . $_POST["cap_id"] . '" class="btn btn-success h4 px-4 text-uppercase">Update completed please NEXT</a><hr class="mb-4">';
        } elseif (isset($_POST["cap_id"]) && $_POST["fst"] == "capHrsUpdate") {
            $sql = "UPDATE `course_active_primary` SET `cap_lecture_hours`=" . $_POST["hrs_lecture"] . ",`cap_lab_hours`=" . $_POST["hrs_laboratory"] . ",`cap_lastupdate`=current_timestamp() WHERE `cap_id` = " . $_POST["cap_id"];
            $fnc->sql_execute($sql);
            echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $_POST["cap_cid"] . "&cap_id=" . $_POST["cap_id"] . "'>";
            // echo '<hr class="mt-4"><a href="cap.php?p=courseview&cap_cid=' . $_POST["cap_cid"] . '&cap_id=' . $_POST["cap_id"] . '" class="btn btn-success h4 px-4 text-uppercase">Update completed please NEXT</a><hr class="mb-4">';
        }
        echo $sql;
        die();
        // echo "<meta http-equiv='refresh' content='" . $fnc->system_meta_refresh . "; URL=cap.php?p=courseview&cap_cid=" . $fnc->get_last_id("course_active_primary", "cap_id") . "'>";

    }


    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>