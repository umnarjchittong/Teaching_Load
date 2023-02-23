<?php
if (isset($_GET["semester"]) && $_GET["semester"] != "") {
    $_SESSION["admin"]["semester"] = $_GET["semester"];
}
if (isset($_GET["edu_year"]) && $_GET["edu_year"] != "") {
    $_SESSION["admin"]["edu_year"] = $_GET["edu_year"];
}
// if (!$_SESSION["admin"]["semester"] || !$_SESSION["admin"]["edu_year"]) {
if (!isset($_SESSION["admin"]["semester"]) || !isset($_SESSION["admin"]["edu_year"])) {
    $sql = "SELECT cap_semester AS semester, cap_year AS edu_year FROM v_cap2 Where cap_citizenid = '" . $_SESSION["admin"]["citizenId"] . "' ORDER BY edu_year DESC , semester DESC LIMIT 1";
    $last_cap = $fnc->get_db_row($sql);
    if (empty($last_cap)) {
        $sql = "SELECT cap_semester AS semester, cap_year AS edu_year FROM v_cap2 ORDER BY edu_year DESC , semester DESC LIMIT 1";
        $last_cap = $fnc->get_db_row($sql);
    }
    $_SESSION["admin"]["semester"] = $last_cap["semester"];
    $_SESSION["admin"]["edu_year"] = $last_cap["edu_year"];
}
$semester = $_SESSION["admin"]["semester"];
$edu_year = $_SESSION["admin"]["edu_year"];

$sql = "SELECT COUNT(setting_id) AS cnt, setting_value, setting_due_date FROM settings WHERE setting_name = 'editable' AND setting_semester = '" . $semester . "' AND setting_edu_year = '" . $edu_year . "' AND setting_due_date >= '" . date("d/m/Y") . "'";
$row = $fnc->get_db_row($sql);
// $fnc->debug_console("setting: ", $sql);
if (isset($row) && $row["cnt"] > 0 && $row["setting_value"] == 'true') {
    // $edit_available = "true";
    $_SESSION["admin"]["editable"] = "true";
    $_SESSION["admin"]["editable_duedate"] = $row["setting_due_date"];
} else {
    $_SESSION["admin"]["editable"] = "false";
}
if ($_SESSION["admin"]["auth_lv"] >= 9) {
    $_SESSION["admin"]["editable"] = "true";
}

$_SESSION["admin"]["setting"]["course_p_100"] = null;
$_SESSION["admin"]["setting"]["studio_ps_100"] = null;
$_SESSION["admin"]["setting"]["coop_ps_0"] = null;

?>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light bg-gradient box_shadow d-print-none" style="background-color: #e3f2fd; font-size: 0.85em;">
    <div class="container-fluid">
        <a class="navbar-brand text-success fw-bold" href="../admin/">Arch's TLS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <!-- <li class="nav-item">
                            <a class="nav-link" href="?p=teacherreport">ภาระงานสอนของฉัน</a>
                        </li> -->
                <?php if ($_SESSION["admin"]["auth_lv"] >= 3 && $_SESSION["admin"]["auth_lv"] <= 5) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="board.php?p=userview">ภาระงานสอนของฉัน</a>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="course.php?p=courseReport" role="button" aria-haspopup="true" aria-expanded="false">วิชาที่เปิดสอน</a>
                    <div class="dropdown-menu" style="font-size: 1em;">
                        <a class="dropdown-item" href="course.php?p=courseReport&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">1. วิชาที่เปิดสอน-ทั้งคณะ</a>
                        <!-- <a class="dropdown-item" href="course.php?p=courseReport&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">*2. ค้นหารายวิชา</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="course.php?p=CourseReportAR&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">3. หลักสูตรสถาปัตย์</a>
                        <a class="dropdown-item" href="course.php?p=CourseReportLA&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">4. หลักสูตรภูมิสถาปัตย์</a>
                        <a class="dropdown-item" href="course.php?p=CourseReportLT&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">5. หลักสูตรภูมิทัศน์</a>
                        <a class="dropdown-item" href="course.php?p=CourseReportMURP&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">6. หลักสูตรการวางผังเมือง</a>
                        <a class="dropdown-item" href="course.php?p=CourseReportAV&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">7. หลักสูตรการออกแบบสิ่งแวดล้อม</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ภาระงานสอน</a>
                    <div class="dropdown-menu" style="font-size: 1em;">
                        <a class="dropdown-item" href="index.php?p=teacherreport">1. ภาระงานสอน-คณะ</a>
                        <a class="dropdown-item" href="index.php?p=externalreport">2. ภาระงานสอน-อ.พิเศษ</a>
                        <!-- <a class="dropdown-item" href="?p=curriculumreport">ภาระงานสอน-หลักสูตร</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php?p=curriculumReportAR&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">3. หลักสูตรสถาปัตย์</a>
                        <a class="dropdown-item" href="index.php?p=curriculumReportLA&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">4. หลักสูตรภูมิสถาปัตย์</a>
                        <a class="dropdown-item" href="index.php?p=curriculumReportLT&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">5. หลักสูตรภูมิทัศน์</a>
                        <a class="dropdown-item" href="index.php?p=curriculumReportMURP&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">6. หลักสูตรการวางผังเมือง</a>
                        <a class="dropdown-item" href="index.php?p=curriculumReportAV&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>">7. หลักสูตรการออกแบบสิ่งแวดล้อม</a>
                    </div>
                </li>
                <?php if ($_SESSION["admin"]["auth_lv"] >= 7) { ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="course.php?p=teacherreport">รายงานภาระงานสอน</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">สำหรับเจ้าหน้าที่</a>
                        <div class="dropdown-menu" style="font-size: 1em;">
                            <a class="dropdown-item" aria-current="page" href="course.php?p=courseregist">1. ลงทะเบียนวิชา</a>
                            <a class="dropdown-item" href="course.php?">2. จัดการวิชาที่เปิดสอน</a>
                            <a class="dropdown-item" href="index.php?p=curriculumTeacher&dept=สถาปัตยกรรมศาสตร์" target="_top">3. อ.ประจำหลักสูตร</a>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=extTeacher">4. อาจารย์พิเศษ</a>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=courseStudio" target="_top">5. รายวิชาสตูดิโอ</a>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=courseZero" target="_top">6. รายวิชาไม่นับ ชม. สอน</a>
                            <?php if ($_SESSION["admin"]["auth_lv"] == 9) { ?>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=editable" target="_top">7. ตั้งค่าการแก้ไขข้อมูล</a>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=teacherUpdate" target="_top">8. อัพเดทข้อมูลคณาจารย์</a>
                            <a class="dropdown-item" aria-current="page" href="setting.php?p=test" target="_top">9. Testing</a>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
                <?php if ($_SESSION["admin"]["auth_lv"] >= 9) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Log As</a>
                        <div class="dropdown-menu" style="font-size: 1em;">
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=admin" target="_top">Developer</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=dean" target="_blank">Dean</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=board" target="_blank">Punravee</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=officer" target="_blank">Officer</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=augcharee" target="_blank">Augcharee</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=kittipong" target="_blank">Kittpong</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=nikorn" target="_blank">Nikorn</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=panawat" target="_blank">Panawat</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=parinya" target="_blank">Parinya</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=porntip" target="_blank">Porntip</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=supanut" target="_blank">Supanut</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=tanwutta" target="_blank">Tanwutta</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=wittaya" target="_blank">Wittaya</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=wuttikan" target="_blank">Wuttikan</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=yaowanit" target="_blank">Yaowanit</a>
                            <a class="dropdown-item" href="../sign/logas.php?p=logAs&logAs=yuttapoom" target="_blank">Yuttapoom</a>
                            <!-- <a class="dropdown-item" href="#">Action</a> -->
                        </div>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="../sign/?p=signout">ออกจากระบบ</a>
                </li>
                <!-- <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
          </li> -->
            </ul>
            <!-- <form class="d-flex">
          <input class="form-control form-control-sm me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-sm btn-outline-success" type="submit">Search</button>
        </form> -->
        </div>
    </div>
</nav>