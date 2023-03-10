<!doctype html>
<?php
include("../core.php");
$fnc = new Web();
if (empty($_SESSION["admin"])) {
    // echo '<meta http-equiv="refresh" content="1;url=../sign/">';
} else {
    if ($_SESSION["admin"]["homepage"] != $fnc->get_url_filename()) {
        echo '<meta http-equiv="refresh" content="0;url=../admin/' . $_SESSION["admin"]["homepage"] . '?p=welcome">';
    }
}
$fnc->debug_console("admin", $_SESSION["admin"]);
$MJU_API = new MJU_API();
$api_person_faculty = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
$api_person = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
$semester = NULL;
$edu_year = NULL;
// if (isset($_GET["semester"]) && $_GET["semester"] != "") {
//     // $semester = $_GET["semester"];
//     $_SESSION["admin"]["semester"] = $_GET["semester"];
// }
// if (isset($_GET["edu_year"]) && $_GET["edu_year"] != "") {
//     // $edu_year = $_GET["edu_year"];
//     $_SESSION["admin"]["edu_year"] = $_GET["edu_year"];
// }
if (isset($_GET["cap_uid"]) && strlen($_GET["cap_uid"]) == 13) {
    $uid = $_GET["cap_uid"];
} else {
    $uid = $_SESSION["admin"]["citizenId"];
}
// if (!$_SESSION["admin"]["semester"] || !$_SESSION["admin"]["edu_year"]) {
//     $sql = "Select coap.cap_semester, coap.cap_year From course_active_primary coap Inner Join course_active_secondary coas On coas.cap_id = coap.cap_id Where (coap.cap_citizenid = '" . $uid . "') Or (coas.cas_citizenid = '" . $uid . "') Order By coap.cap_year Desc, coap.cap_semester Desc LIMIT 1";
//     if (!empty($last_cap)) {
//         // $semester = $last_cap["cap_semester"];
//         // $edu_year = $last_cap["cap_year"];
//         $_SESSION["admin"]["semester"] = $last_cap["cap_semester"];
//         $_SESSION["admin"]["edu_year"] = $last_cap["cap_year"];
//     } else {
//         // $semester = 1;
//         // $edu_year = date("Y") + 543;
//         $_SESSION["admin"]["semester"] = 1;
//         $_SESSION["admin"]["edu_year"] = date("Y") + 543;
//     }
// }
if (isset($_GET["semester"]) && isset($_GET["edu_year"])) {
    $semester = $_GET["semester"];
    $edu_year = $_GET["edu_year"];
} elseif (isset($_SESSION["admin"]["semester"])) {
    $semester = $_SESSION["admin"]["semester"];
    $edu_year = $_SESSION["admin"]["edu_year"];
} else {
    $fnc->get_newest_semester_edu_year($uid);
}
?>
<html lang="en">

<head>
    <title>Teaching Load</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../style.css">

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
                $fnc->view_user($uid, $semester, $edu_year);
                break;
            case "teacherreport":
                if (isset($_GET["semester"]) && isset($_GET["edu_year"])) {
                    $fnc->teacher_report($semester, $edu_year);
                }
                break;
            case "welcome":
                if (isset($_GET["semester"]) && isset($_GET["edu_year"])) {
                    $fnc->view_user($uid, $semester, $edu_year);
                } else {

                    $fnc->view_user($uid, $_SESSION["admin"]["semester"], $_SESSION["admin"]["edu_year"]);
                }
                break;
        }
    } else {
        // $fnc->cap_form();
        $fnc->cap_table($_SESSION["admin"]["semester"], $_SESSION["admin"]["edu_year"]);
    }

    ?>

    <!-- footer -->
    <div class="py-3"></div>
    <footer class="footer mt-auto py-2 bg-light">
        <div class="container text-center" style="font-size: 0.8em;">
            <span class="text-muted text-capitalize">????????????????????????????????????????????????????????????????????????????????????????????????????????????<br>????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? ???????????????????????????????????????????????????<br>
                last update: <?= date("M d, Y") ?></span>
        </div>
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <?php include('../sweet_alert.php'); ?>
</body>

</html>