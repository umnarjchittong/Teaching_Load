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

if (isset($_GET["sid"]) && isset($_GET["sval"])) {
    $sql = "UPDATE settings SET setting_value = '" . $_GET["sval"] . "' WHERE setting_id = " . $_GET["sid"];
    $fnc->sql_execute($sql);
}

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
        <div class="container h6 text-end"><?= "<span class='text-warning'>Editor:</span> " . $_SESSION["admin"]["titlePosition"] . $_SESSION["admin"]["firstName"] . "&nbsp;&nbsp;" . $_SESSION["admin"]["lastName"] ?></div>
    <?php } ?>

    <?php
    function editable_setting()
    {
        global $fnc;
        echo '<div class="container border-bottom mb-4 mt-4">';
        echo '  <div class="page_header_main bg-gradient">';
        echo '      <h5>การตั้งค่า</h5>';
        echo '  </div>';
        if (isset($_GET["sid"]) && isset($_GET["act"]) && $_GET["act"] == "edit") {
            $row = $fnc->get_db_row("SELECT * FROM settings WHERE setting_id = " . $_GET["sid"]);
            if ($row["setting_value"] == "true") {
                $fix_link = "false";
                $status = 'Enable Editing';
                $btn_text = 'Disable';
            } else {
                $fix_link = "true";
                $status = 'Disabled Editing';
                $btn_text = 'Enable';
            }
            echo '      <div class="card border-warning mb-3 text-white bg-secondary shadow col-12 col-md-6 mx-auto">';
            echo '          <div class="card-header h5 text-center text-warning">' . $row["setting_semester"] . " / " . $row["setting_edu_year"] . '</div>';
            echo '<form name="setting_update" method="post" action="../db_mgt.php">';
            echo '          <div class="card-body pb-1">';
            echo '              <p class="card-title">';
            echo '                  <div class="mb-3 row">';
            echo '                      <label for="setting_due_date" class="col-4 col-form-label">ปิดการแก้ไข</label>';
            echo '                      <div class="col">';
            echo '                          <input type="date" id="setting_due_date" name="setting_due_date" class="form-control" value="' . $row["setting_due_date"] . '">';
            echo '                      </div>';
            echo '                  </div>';
            echo '              </p>';            
            echo '              <p class="card-text"><span class="text-white-50">สถานะปัจจุบัน : </span>' . $status . '</p>';
            echo '              <div class="card-footer row row-cols-2 gx-3">';
            echo '                  <div class="col">';
            echo '                      <a href="setting.php?p=editable" class="btn btn-sm btn-light w-100 text-decoration-none">cancel</a>';
            echo '                  </div>';
            echo '                  <div class="col">';
            // echo '                      <a href="setting.php?p=editable&sid=' . $row["setting_id"] . '&act=edit" class="btn btn-sm btn-primary w-100 text-decoration-none">save</a>';
            echo '<input type="hidden" name="fst" value="setting_update">';
            // echo '<input type="hidden" name="p" value="editable">';
            echo '<input type="hidden" name="sid" value="' . $row["setting_id"] . '">';
            echo '                      <button type="submit" name="setting_save" class="btn btn-sm btn-primary w-100 text-decoration-none">save</button>';
            echo '                  </div>';
            echo '              </div>';
            echo '          </div>';
            echo '</form>';
            echo '      </div>';
        } else {
        echo '  <div class="row row-cols-1 row-cols-md-3 g-4">';
        $sql = "SELECT * FROM settings WHERE setting_name = 'editable' ORDER BY setting_edu_year, setting_semester ASC";
        $data_array = $fnc->get_db_array($sql);
        $fnc->debug_console("setting data:", $data_array);
        foreach ($data_array as $data) {
            if ($data["setting_value"] == "true") {
                $fix_link = "false";
                $status = 'Enable Editing';
                $btn_text = 'Disable';
            } else {
                $fix_link = "true";
                $status = 'Disabled Editing';
                $btn_text = 'Enable';
            }
            echo '  <div class="col mx-auto">';
            echo '      <div class="card border-info mb-3 text-white bg-secondary shadow">';
            echo '          <div class="card-header h5 text-center text-warning">' . $data["setting_semester"] . " / " . $data["setting_edu_year"] . '</div>';
            echo '          <div class="card-body pb-1">';
            echo '              <p class="card-title"><span class="text-white-50">ปิดการแก้ไขวันที่ : </span>';
            echo $fnc->get_date_semi_th($data["setting_due_date"]);
            echo '              </p>';            
            echo '              <p class="card-text"><span class="text-white-50">สถานะปัจจุบัน : </span>' . $status . '</p>';
            echo '              <div class="card-footer row row-cols-2 gx-3">';
            echo '                  <div class="col">';
            echo '                      <a href="setting.php?p=editable&sid=' . $data["setting_id"] . '&sval=' . $fix_link . '" class="btn btn-sm btn-info w-100 text-decoration-none">' . $btn_text . '</a>';
            echo '                  </div>';
            echo '                  <div class="col">';
            echo '                      <a href="setting.php?p=editable&sid=' . $data["setting_id"] . '&act=edit" class="btn btn-sm btn-info w-100 text-decoration-none">EDIT</a>';
            echo '                  </div>';
            echo '              </div>';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
        }
        echo '  </div>';
    }
        echo '</div>';
    }

    function course_open_list()
    {
        global $fnc;
        $sql = "SELECT cap_semester,cap_year FROM course_active_primary GROUP BY cap_semester, cap_year ORDER BY cap_year, cap_semester";
        $data_array = $fnc->get_db_array($sql);
        echo '<div class="container border-bottom mb-4 mt-4">';
        echo '<h5 class="text-info">ภาคการศึกษาที่เปิดวิชาสอนในระบบทั้งหมด</h5>';
        echo '<div class="ms-3">';
        foreach ($data_array as $data) {
            echo '<a href="course.php?p=courseReport&semester=' . $data["cap_semester"] . '&edu_year=' . $data["cap_year"] . '" target="_top">' . $data["cap_semester"] . " / " . $data["cap_year"] . '</a>' . '<br>';
        }
        echo '</div>';
        echo '</div>';
    }

    if (isset($_GET["p"]) && $_GET["p"] != "") {
        switch ($_GET["p"]) {
            case "editable":
                editable_setting();
                course_open_list();
                break;
            case "curriculumTeacher":
                $fnc->curriculum_teacher_form();
                break;
            case "extTeacher":
                // $fnc->cap_table($semester, $edu_year);
                // echo '<div class="text-center text-warning h3 my-5 text-uppercase">...Coming Soon...</div>';
                $fnc->ext_teacher_form();
                break;
            case "courseStudio":
                // $fnc->cap_table($semester, $edu_year);
                // echo '<div class="text-center text-warning h3 my-5 text-uppercase">...Coming Soon...</div><hr>';
                $fnc->course_studio_form();
                break;
            case "courseZero":
                // $fnc->cap_table($semester, $edu_year);
                // echo '<div class="text-center text-warning h3 my-5 text-uppercase">...Coming Soon...</div><hr>';
                $fnc->course_zero_form();
                break;
            case "teacherUpdate":
                echo '<div class="text-center text-warning h3 my-5 text-uppercase">...Teacher Update...</div>';
                if (isset($_GET["act"]) && $_GET["act"] == "update") {
                    $fnc->get_teacher_update();
                    echo '<div class="text-center text-warning h3 mt-3 my-5 text-uppercase"><p class="btn btn-lg btn-success px-5">update completed</p></div>';
                } else {
                    echo '<div class="text-center text-warning h3 mt-3 my-5 text-uppercase"><a href="setting.php?p=teacherUpdate&act=update" target="_top" class="btn btn-lg btn-outline-info">Update now !</a></div>';
                }
                break;
            case "test":
                // $fnc->cap_table($semester, $edu_year);
                echo '<div class="text-center text-warning h4 my-5 text-uppercase">TESTING DATA</div>';
                echo '<div class="text-muted p-5 col-10 mx-auto bg-light fs-6 fw-lighter">';
                echo addslashes(json_encode(array("semester" => $semester, "edu_year" => $edu_year, "close_date" => date("d/m/Y"))));
                echo '</div>';

                echo '<div class="text-muted p-5 mt-3 col-10 mx-auto bg-light fs-6 fw-lighter">';
                echo '<h3 class="text-warning">update all course primary teacher set to 100%</h3>';
                $sql = "Select course_active_primary.cap_id, course_active_primary.cap_semester, course_active_primary.cap_year, course.course_code_th, course.course_name_th, course_active_primary.cap_citizenid, course.course_lec, course.course_lab_hrs, course_active_primary.cap_lecture_hours, course.course_lab, course.course_lec_hrs, course_active_primary.cap_lab_hours From course_active_primary Inner Join course On course.course_id = course_active_primary.course_id 
                Where course_active_primary.cap_semester = " . $_SESSION["admin"]["semester"] . " And course_active_primary.cap_year = '" . $_SESSION["admin"]["edu_year"] . "' And course.course_studio = '' Order By course.course_code_th";
                $data_array = $fnc->get_db_array($sql);
                $sql_update = "";
                foreach ($data_array as $row) {
                    $sql_update .= "UPDATE course_active_primary SET cap_lecture_hours='" . ($row["course_lec"] * $row["course_lec_hrs"]) . "',cap_lab_hours='" . ($row["course_lab"] * $row["course_lab_hrs"]) . "', cap_lastupdate = CURRENT_TIMESTAMP WHERE course_id = " . $row["cap_id"] . "; ";
                }
                echo '<p style="font-size: 0.75em">' . $sql_update . '</p>';
                $_SESSION["admin"]["setting"]["course_p_100"] = json_encode($sql_update, true);
                echo '<a href="../db_mgt.php?p=test&qst=dbexcutes&parameter=course_p_100" target="_top" class="btn btn-outline-danger">Database Excutes</a>';
                echo '</div>';

                echo '<div class="text-muted p-5 mt-3 col-10 mx-auto bg-light fs-6 fw-lighter">';
                echo '<h3 class="text-warning">update studio course primary and secondary to 100%</h3>';
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
                echo '<p style="font-size: 0.75em">' . $sql_update . '</p>';
                // $_SESSION["admin"]["setting"]["studio_ps_100"] = json_encode($sql_update, true);
                // echo '<a href="../db_mgt.php?p=test&qst=dbexcutes&parameter=studio_ps_100" target="_top" class="btn btn-outline-danger">Database Excutes</a>';
                echo '</div>';

                // วิชาที่ไม่นำมาคำนวณ ชม. ต่อภาคการศึกษา
                // ! *****
                echo '<div class="text-muted p-5 mt-3 col-10 mx-auto bg-light fs-6 fw-lighter">';
                echo '<h3 class="text-warning">update course hours สหกิจศึกษา to zero on primary and secondary</h3>';
                $studio_course = $fnc->get_db_array("SELECT cap_id FROM course_active_primary INNER JOIN course ON course_active_primary.course_id = course.course_id WHERE course_studio = 'zero'");
                // $fnc->debug_console("studio_course sql: ", $studio_course);
                $sql_update = "";
                foreach ($studio_course as $stucourse) {
                    $sql_update .= "UPDATE course_active_primary SET cap_lecture_hours='0', cap_lab_hours='0', cap_lastupdate = CURRENT_TIMESTAMP WHERE course_id = " . $stucourse["cap_id"] . "; ";
                    $sql_update .= "UPDATE course_active_secondary SET cas_lecture_hours='0', cas_lab_hours='0', cas_lastupdate = CURRENT_TIMESTAMP WHERE cap_id = " . $stucourse["cap_id"] . "; ";
                }
                echo '<p style="font-size: 0.75em">' . $sql_update . '</p>';
                // $_SESSION["admin"]["setting"]["coop_ps_0"] = json_encode($sql_update, true);
                // echo '<a href="../db_mgt.php?p=test&qst=dbexcutes&parameter=coop_ps_0" target="_top" class="btn btn-outline-danger">Database Excutes</a>';
                echo '</div>';

                break;
        }
    } else {
        echo '<div class="text-center text-warning h3 my-5 text-uppercase">...Settings Menu...</div>';
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