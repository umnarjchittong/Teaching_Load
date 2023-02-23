<!doctype html>
<?php
include("../core.php");
$fnc = new Web();
$MJU_API = new MJU_API();
$api_person_faculty = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
$api_person = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
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

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            size: 1rem;
            /* background-color: #FFF; */
        }

        a {
            text-decoration: none;
        }

        a:hover,
        a:focus {
            text-decoration: underline;
            /* font-weight: bold; */
            color: gray;
        }

        .page_header {
            padding: 1.5em 0em 1em 0em;
            margin-bottom: 1.5em;
            text-align: center;
            background-color: #489fff;
            border-radius: 20px;
            color: white;
        }

        .page_header_main {
            padding: 1.5em 0em 1em 0em;
            margin-bottom: 1.5em;
            text-align: center;
            background-color: #c86840;
            border-radius: 20px;
            color: white;
        }

        .page_header_course {
            padding: 1.5em 0em 1em 0em;
            margin-bottom: 1.5em;
            text-align: center;
            background-color: #6cb398;
            border-radius: 20px;
            color: white;
        }
    </style>

</head>

<body>
    <div class="wrapper">



        <?php
        // * display table cap
        function view_user()
        {
            global $fnc, $MJU_API, $api_person;

            $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $_GET["cap_uid"] . "'";
            $cap_info = $fnc->get_db_array($sql)[0];
            if (empty($cap_info)) {
                die();
            }
            $fnc->debug_console("cap_info filter sql: ", $cap_info);
            $user_info = $MJU_API->GetAPI_array($api_person . $cap_info["cap_citizenid"])[0];
            $fnc->debug_console("user_info: ", $user_info);

            if (isset($_GET["semester"])) {
                $cap_info["cap_semester"] = $_GET["semester"];
            }
            if (isset($_GET["edu_year"])) {
                $cap_info["cap_year"] = $_GET["edu_year"];
            }


        ?>
            <div class="container border-bottom mb-4">
                <form action="?" method="get" class="mt-4">
                    <div class="page_header">
                        <h2 class="h2">ภาระงานสอนอาจารย์</h2>
                    </div>
                    <div class="row">
                        <div class="col-4 col-md-7">
                            <p class="title h3 text-primary"><?= $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></p>
                            <p class="title h4">ภาคการศึกษา <?= $cap_info["cap_semester"] . "/" . $cap_info["cap_year"]; ?></p>
                            <p class="title h4">ภาคบรรบาย <label id="user_lec_hrs">0</label> ชม. , ภาคปฏิบัติ <label id="user_lab_hrs">0</label> ชม.</p>
                        </div>
                        <div class="col align-self-end">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <select id="semester" name="semester" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_semester"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ภาคการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <select id="edu_year" name="edu_year" class="form-select" aria-label="Default select example" onchange="this.form.submit()">
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_year"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>ปีการศึกษา ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cap_uid" value="<?= $_GET["cap_uid"]; ?>">
                </form>

                <div class="table mb-3">
                    <table class="table table-bordered mt-4">
                        <!-- table table-striped table-bordered table-hover table-responsive"> -->
                        <?php
                        $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $cap_info["cap_citizenid"] . "' AND cap_semester = " . $cap_info["cap_semester"] . " AND cap_year = '" . $cap_info["cap_year"] . "' ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc, cap_notes Asc";
                        $cap_list = $fnc->get_dataset_array($sql);
                        $fnc->debug_console("cap_list sql: " . $sql);
                        ?>
                        <thead class="thead-inverse">
                            <tr class="">
                                <th class="text-center h4" colspan="3" style="background-color: #cae4f4;">เจ้าของวิชา</th>
                            </tr>
                            <tr class="">
                                <th class="text-center align-items-center">รหัส - ชื่อวิชา</th>
                                <th class="text-center">ภาคบรรยาย (ชม.)</th>
                                <th class="text-center">ภาคปฏิบัติ (ชม.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($cap_list)) {
                                $hrs_lec_sum = 0;
                                $hrs_lab_sum = 0;
                                foreach ($cap_list as $cap) {
                            ?>
                                    <tr class="">
                                        <td scope="row"><a href="cap.php?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                                <?php if (!empty($cap["course_credit"])) {
                                                    echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                                                } ?>
                                            </a></td>
                                        <?php
                                        $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                        ?>
                                        <!-- <td class="text-center"><a href="cap.php?p=userview&cap_uid=<? //= $cap["cap_citizenid"] . '">' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; 
                                                                                                            ?></a></td> -->
                                        <!-- <td class="text-center">เจ้าของวิชา</td> -->
                                        <td class="text-center"><?= $cap["cap_lecture_hours"] ?></td>
                                        <td class="text-center"><?= $cap["cap_lab_hours"] ?></td>
                                    </tr>
                            <?php
                                    $hrs_lec_sum += $cap["cap_lecture_hours"];
                                    $hrs_lab_sum += $cap["cap_lab_hours"];
                                }
                            } else {
                                echo '<tr class="">
                                    <th class="text-center" colspan="3" style="background-color: #dfdfdf">ไม่พบข้อมูล</th>
                                </tr>';
                            }
                            // $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $cap_info["cap_citizenid"] . "' AND cap_semester = " . $cap_info["cap_semester"] . " AND cap_year = '" . $cap_info["cap_year"] . "' ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc, cap_notes Asc";
                            // $sql = "Select * From course_active_primary coap Right Join course_active_secondary coas On coas.cap_id = coap.cap_id Left Join teacher_additional tead On tead.ta_citizenid = coas.cas_citizenid Where coas.cas_citizenid LIKE '" . $cap_info["cap_citizenid"] . "' And coas.cas_status = 'enable' And coap.cap_status = 'enable' AND coap.cap_semester = " . $cap_info["cap_semester"] . " AND coap.cap_year = '" . $cap_info["cap_year"] . "' ORDER BY coap.cap_year Desc, coap.cap_semester Desc, course_code_th Asc, coap.cap_notes Asc";
                            $sql = "Select * From course_active_primary coap Right Join course_active_secondary coas On coas.cap_id = coap.cap_id Left Join teacher_additional tead On tead.ta_citizenid = coas.cas_citizenid Left Join course cou On coap.course_id = cou.course_id 
                            Where coas.cas_citizenid LIKE '" . $cap_info["cap_citizenid"] . "' And coas.cas_status = 'enable' And coap.cap_status = 'enable' And coap.cap_semester = " . $cap_info["cap_semester"] . " And coap.cap_year = '" . $cap_info["cap_year"] . "' Order By coap.cap_year, coap.cap_semester, cou.course_code_th, coap.cap_notes";
                            $fnc->debug_console("cap_list ta sql: " . $sql);
                            $cap_list = $fnc->get_dataset_array($sql);
                            ?>
                            <tr class="">
                                <th class="text-center" colspan="3"></th>
                            </tr>
                            <thead class="thead-inverse mt-2">
                                <tr class="">
                                    <th class="text-center h4" colspan="3" style="background-color: #cef0d0;">ผู้สอนร่วม</th>
                                </tr>
                                <tr class="">
                                    <th class="text-center align-items-center">รหัส - ชื่อวิชา</th>
                                    <th class="text-center">ภาคบรรยาย (ชม.)</th>
                                    <th class="text-center">ภาคปฏิบัติ (ชม.)</th>
                                </tr>
                            </thead>
                            <?php
                            if (!empty($cap_list)) {
                                foreach ($cap_list as $cap) {
                            ?>
                                    <tr class="">
                                        <td scope="row"><a href="cap.php?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                                <?php if (!empty($cap["course_credit"])) {
                                                    echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                                                } ?>
                                            </a></td>
                                        <td class="text-center"><?= $cap["cas_lecture_hours"] ?></td>
                                        <td class="text-center"><?= $cap["cas_lab_hours"] ?></td>
                                    </tr>
                            <?php
                                    $hrs_lec_sum += $cap["cas_lecture_hours"];
                                    $hrs_lab_sum += $cap["cas_lab_hours"];
                                }
                            } else {
                                echo '<tr class="">
                                            <th class="text-center text-mute" colspan="3" style="background-color: #dfdfdf">ไม่พบข้อมูล</th>
                                        </tr>';
                            }
                            ?>
                        </tbody>
                        <script type="text/javascript">
                            document.getElementById("user_lec_hrs").innerHTML = <?= $hrs_lec_sum; ?>;
                            document.getElementById("user_lab_hrs").innerHTML = <?= $hrs_lab_sum; ?>;
                        </script>
                    </table>
                </div>

                <div class="text-end mt-5 mb-3">
                    <a href="cap.php" target="_top" class="btn btn-secondary text-uppercase px-5">close</a>
                </div>

            </div>
        <?php } ?>

        <?php
        function get_hrs($capID)
        {
            global $fnc;
            $sql = "Select coap.cap_lecture_hours as hrs_lec, coap.cap_lab_hours as hrs_lab From course_active_primary coap Where coap.cap_id = " . $capID;
            $hrs = $fnc->get_db_array($sql);
            $sql = "Select coas.cas_lecture_hours as hrs_lec, coas.cas_lab_hours as hrs_lab From course_active_primary coap Left Join course_active_secondary coas On coap.cap_id = coas.cap_id Where coas.cas_status = 'enable' AND coap.cap_id = " . $capID;
            $ta_array = $fnc->get_db_array($sql);
            if (!empty($ta_array)) {
                foreach ($ta_array as $ta) {
                    array_push($hrs, array("hrs_lec" => $ta["hrs_lec"], "hrs_lab" => $ta["hrs_lab"]));
                }
            }
            $fnc->debug_console("hrs: ", $hrs);
            // echo "sum of hrs";
            // ! ******
            $hrs_sum = array("lec" => 0, "lab" => 0);
            foreach ($hrs as $hr) {
                $hrs_sum["lec"] += $hr["hrs_lec"];
                $hrs_sum["lab"] += $hr["hrs_lab"];
            }
            array_push($hrs, array("hrs_lec_sum" => $hrs_sum["lec"], "hrs_lab_sum" => $hrs_sum["lab"]));
            $fnc->debug_console("hrs sum : ", $hrs);
            // echo $hrs[count($hrs) - 1]["hrs_lec_sum"] . " / " . $hrs[count($hrs) - 1]["hrs_lab_sum"];
            return $hrs;
        }

        function gen_hrs_form_update($cap_info, $hrs_lec, $hrs_lab, $hrs)
        {
            if (isset($_GET["cas_id"])) {
                echo '<form method="post" action="db_mgt.php?act=cashrsupdate">';
                echo '<input type="hidden" name="fst" value="casHrsUpdate">';
            } else {
                echo '<form method="post" action="db_mgt.php?act=caphrsupdate">';
                echo '<input type="hidden" name="fst" value="capHrsUpdate">';
            }
            echo '<div class="row gx-2">';
            echo '<div class="col-6 col-lg-3"><label for="hrs_lecture" class="form-label">ภาคบรรยาย</label><select class="form-select" id="hrs_lecture" name="hrs_lecture">';
            for ($i = (($cap_info["course_lec"] * $cap_info["course_lec_hrs"]) - $hrs[count($hrs) - 1]["hrs_lec_sum"] + $hrs_lec); $i >= 0; $i--) {
                // for ($i = 0; $i <= (($cap_info["course_lec"] * $hrs_lec_multiply) - $hrs[count($hrs) - 1]["hrs_lec_sum"] + $hrs_lec); $i++) {
                echo '<option value="' . $i . '"';
                if ($i == $hrs_lec) {
                    echo ' selected';
                }
                echo '>' . $i . ' hrs</option>';
            }
            echo '</select> </div>';
            // echo '(' . $cap_info["course_lab"] . ' * ' . $cap_info["course_lab_hrs"] . ') - ' . $hrs[count($hrs) - 1]["hrs_lab_sum"] . ' + ' . $hrs_lab;
            echo '<div class="col-6 col-lg-3"><label for="hrs_lecture" class="form-label">ภาคปฏิบัติ</label><select class="form-select" name="hrs_laboratory">';
            // for ($i = 0; $i <= (($cap_info["course_lab"] * $hrs_lab_multiply) - $hrs[count($hrs) - 1]["hrs_lab_sum"] + $hrs_lab); $i++) {
            for ($i = (($cap_info["course_lab"] * $cap_info["course_lab_hrs"]) - $hrs[count($hrs) - 1]["hrs_lab_sum"] + $hrs_lab); $i >= 0; $i--) {
                echo '<option value="' . $i . '"';
                if ($i == $hrs_lab) {
                    echo ' selected';
                }
                echo '>' . $i . ' hrs</option>';
            }
            echo '</select> </div>';
            echo '<div class="col-12 col-lg-6 mt-3 mt-lg-0 align-self-end text-center text-md-end">';
            if (isset($_GET["cap_id"])) {
                echo '<input type="hidden" name="cap_id" value="' . $_GET["cap_id"] . '">';
            }
            if (isset($_GET["cas_id"])) {
                echo '<input type="hidden" name="cas_id" value="' . $_GET["cas_id"] . '">';
            }
            echo '<input type="hidden" name="cap_cid" value="' . $_GET["cap_cid"] . '">';
            echo '<a href="cap.php?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '" target="_top" class="btn btn-sm btn-secondary px-4 me-2">ยกเลิก</a>';
            echo '<input type="submit" name="submit" value="บันทึก" class="btn btn-sm btn-primary px-4">';
            echo '</div>';
            echo '</form>';
        }

        // * display table cap
        function view_course_primary()
        {
            global $fnc, $MJU_API, $api_person;

            $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
            $fnc->debug_console("view course primary sql: ", $sql);
            $cap_info = $fnc->get_db_array($sql)[0];
            $fnc->debug_console("cap_info filter: ", $cap_info);
            $user_info = $MJU_API->GetAPI_array($api_person . $cap_info["cap_citizenid"])[0];
            $fnc->debug_console("user_info: ", $user_info);

            if (isset($_GET["semester"])) {
                $cap_info["cap_semester"] = $_GET["semester"];
            }
            if (isset($_GET["edu_year"])) {
                $cap_info["cap_year"] = $_GET["edu_year"];
            }

        ?>
            <div class="container border-bottom mb-4">
                <form action="?" method="get" class="mt-4">
                    <div class="page_header_course">
                        <h2 class="h2">รายละเอียดวิชาที่เปิดสอน</h2>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-8 mb-3">
                            <!-- <h2 class="" style="color: lightgreen;">Course View2</h2> -->
                            <h3 class="title h3 text-primary"><?= $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . ' ' . $cap_info["cap_notes"]; ?></h3>
                            <h4 class="h4"><?= $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lec"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ')'; ?>
                                <?php
                                // if (empty($cap_info["course_lec"]) || empty($cap_info["course_lab"])) {
                                echo '<a href="cap.php?p=courseedit&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '" class="btn btn-sm btn-warning ms-2">แก้ไขหน่วยกิต</a>';
                                // }
                                ?></h4>
                        </div>
                        <div class="col align-self-end mb-2">
                            <div class="row gx-2">
                                <div class="col-6 form-group">
                                    <label for="semester" class="form-label">ภาคการศึกษา</label>
                                    <select id="semester" name="semester" class="form-select form-select-sm" onchange="this.form.submit()" disabled>
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_semester"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="edu_year" class="form-label">ปีการศึกษา</label>
                                    <select id="edu_year" name="edu_year" class="form-select form-select-sm" onchange="this.form.submit()" disabled>
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if ($cap_info["cap_year"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="p" value="courseview">
                    <input type="hidden" name="cap_cid" value="<?= $_GET["cap_cid"]; ?>">
                    <input type="hidden" name="cap_id" value="<?= $_GET["cap_id"]; ?>">
                </form>

                <div class="table mb-3">
                    <table class="table table-bordered mt-4">
                        <!-- table table-striped table-bordered table-hover table-responsive"> -->
                        <thead class="thead-inverse">
                            <tr class="">
                                <th>ผู้สอน</th>
                                <th>ภาระงานสอน (ชม.)<?php $hrs = get_hrs($_GET["cap_id"]); ?></th>
                                <th class="text-end"><?php if (!isset($_GET["ta"]) && !isset($_GET["hrs"])) {
                                                            echo '<a href="?' . $_SERVER["QUERY_STRING"] . '&ta=form" class="btn btn-sm btn-primary">เพิ่มผู้สอนร่วม</a>';
                                                        } ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                            $sql .= " AND cap_semester = " . $cap_info["cap_semester"] . " AND cap_year = '" . $cap_info["cap_year"] . "'";
                            $sql .= " ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc";
                            $cap_list = $fnc->get_db_array($sql);
                            $fnc->debug_console("course view table:", $cap_list);

                            if ($cap_list) {
                                foreach ($cap_list as $cap) {
                                    $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                            ?>
                                    <tr class="">
                                        <td scope="row" nowrap><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                                        <?php
                                        if (isset($_GET["hrs"]) && $_GET["hrs"] == "capedit" && isset($_GET["cap_id"]) && $cap["cap_id"] == $_GET["cap_id"]) {
                                            echo '<td colspan="2">';
                                            gen_hrs_form_update($cap_info, $cap["cap_lecture_hours"], $cap["cap_lab_hours"], $hrs);
                                            echo '</td>';
                                        } else {
                                            echo '<td><span nowrap>บรรยาย : ' . $cap["cap_lecture_hours"] . ' / </span><span nowrap>ปฏิบัติ : ' . $cap["cap_lab_hours"] . '</span></td>';
                                            echo '<td class="text-end">';
                                            if (!empty($cap_info["course_lec"]) && !empty($cap_info["course_lab"])) {
                                                echo '<a href="cap.php?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&hrs=capedit&cap_id=' . $cap["cap_id"] . '" class="btn btn-sm btn-warning">แก้ไขภาระงานสอน1</a>';
                                            }
                                            echo '</td>';
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                // * get teacher assistant list adn display as table here
                                $sql = "Select * From course_active_secondary coas Where coas.cas_status = 'enable' AND coas.cap_id = " . $cap_info["cap_id"];
                                $cas_array = $fnc->get_db_array($sql);
                                if (!empty($cas_array)) {
                                    foreach ($cas_array as $cas) {
                                        $ta_info = $MJU_API->GetAPI_array($api_person . $cas["cas_citizenid"])[0];
                                    ?>
                                        <tr class="">
                                            <td scope="row"><a href="cap.php?p=userview&cap_uid=<?= $cas["cas_citizenid"]; ?>"><?= $ta_info["firstName"] . '&nbsp;&nbsp;' . $ta_info["lastName"]; ?></a></td>
                                            <?php
                                            if (isset($_GET["hrs"]) && $_GET["hrs"] == "casedit" && isset($_GET["cas_id"]) && $cas["cas_id"] == $_GET["cas_id"]) {
                                                echo '<td colspan="2">';
                                                gen_hrs_form_update($cap_info, $cas["cas_lecture_hours"], $cas["cas_lab_hours"], $hrs);
                                                echo '</td>';
                                            } else {
                                                echo '<td><span nowrap>บรรยาย : ' . $cas["cas_lecture_hours"] . ' / </span><span nowrap>ปฏิบัติ : ' . $cas["cas_lab_hours"] . '</span></td>';
                                                echo '<td class="text-end"><a href="cap.php?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '&hrs=casedit&cas_id=' . $cas["cas_id"] . '" class="btn btn-sm btn-warning">แก้ไขภาระงานสอน</a>
                                                <a href="db_mgt.php?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '&act=casdelete&cas_id=' . $cas["cas_id"] . '" class="btn btn-sm btn-danger ms-2">นำรายชื่อออก</a></td>';
                                            }
                                            ?>
                                        </tr>
                            <?php
                                    }
                                }
                            } else {
                                echo '<tr class="">
                                        <td colspan="3" class="text-secondary text-center my-2">ไม่พบรายวิชานี้ ในภาคการศึกษา ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . '</td>
                                    </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-5 mb-3">
                    <a href="cap.php" target="_top" class="btn btn-secondary text-uppercase px-5">close</a>
                </div>

            </div>

            <?php
            if (isset($_GET["ta"]) && $_GET["ta"] == "form") {
                cas_form($cap_info, $user_info);
                // cas_table();
            }
        }


        // * display course assignment to teacher or open course activation primary teacher
        function cap_form()
        {
            global $fnc, $MJU_API, $api_person_faculty;
            if (isset($_GET["p"]) && $_GET["p"] == "capedit" && isset($_GET["cap_id"])) {
                $title_text = "ปรับปรุงข้อมูลที่ลงทะเบียนไว้";
            } else {
                $title_text = "ลงทะเบียนวิชาที่จะเปิดสอน";
            }
            ?>
            <div class="container border-bottom mb-4 mt-4">
                <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
                <div class="page_header_main">
                    <h2 class="h2"><?= $title_text ?></h2>
                </div>
                <div class="container h-100 px-2 px-md-5 bg-light border rounded-3">
                    <?php
                    if (isset($_GET["cap_id"])) {
                        $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                        $cap_info = $fnc->get_db_array($sql)[0];
                        $fnc->debug_console("cap filter sql: ", $sql);
                        $fnc->debug_console("cap filter array: ", $cap_info);
                        // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                    }
                    ?>
                    <form action="db_mgt.php" method="post" class="mt-4">

                        <div class="row form-group g-3 mb-3">
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <?php
                                    $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                                    ?>
                                    <label for="teacher" class="form-label">เลือกผู้รับผิดชอบวิชา</label>
                                    <select id="teacher" name="teacher" class="form-select" size="10" aria-label="size 3 select example" required>
                                        <!-- <option selected>Open this select menu</option> -->
                                        <?php
                                        foreach ($teacher_list as $t_list) {
                                            echo '<option value="' . $t_list["citizenId"] . '"';
                                            if (isset($cap_info["cap_citizenid"]) && $cap_info["cap_citizenid"] == $t_list["citizenId"]) {
                                                echo " selected";
                                            }
                                            echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row mb-5">
                                    <div class="col-6 form-group">
                                        <label for="semester" class="form-label">ภาคการศึกษา</label>
                                        <select id="semester" name="semester" class="form-select" aria-label="Default select example">
                                            <?php
                                            for ($i = 1; $i <= 3; $i++) {
                                                echo '<option value="' . $i . '"';
                                                if (isset($cap_info["cap_semester"]) && $cap_info["cap_semester"] == $i) {
                                                    echo " selected";
                                                }
                                                echo '>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="edu_year" class="form-label">ปีการศึกษา</label>
                                        <select id="edu_year" name="edu_year" class="form-select" aria-label="Default select example">
                                            <?php
                                            for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                                echo '<option value="' . $i . '"';
                                                if (isset($cap_info["cap_year"]) && $cap_info["cap_year"] == $i) {
                                                    echo " selected";
                                                }
                                                echo '>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 form-group">
                                    <?php
                                    $sql = "SELECT course_id,course_code_th,course_name_th,course_credit,course_lec,course_lab,course_self FROM course WHERE course_status = 'enable'";
                                    $course_list = $fnc->get_dataset_array($sql);
                                    ?>
                                    <label for="course" class="form-label">ชื่อรายวิชา</label>
                                    <input type="text" name="course" id="course" class="form-control" maxlength="80" placeholder="ภท111 เขียนแบบก่อสร้างภูมิทัศน์" <?php if (!empty($cap_info)) {
                                                                                                                                                                        echo ' value="' . $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . '"';
                                                                                                                                                                    } ?>required>
                                </div>

                                <div class="text-end" style="margin-top: 5em;">
                                    <?php
                                    if (isset($_GET["cap_id"])) {
                                        echo '<input type="hidden" name="course_id" value="' . $cap_info["course_id"] . '">';
                                        echo '<input type="hidden" name="fst" value="capupdate">';
                                        echo '<input type="hidden" name="cap_id" value="' . $cap_info["cap_id"] . '">';
                                        echo '<a href="cap.php" target="_top" class="btn btn-secondary text-uppercase px-4 me-2">ย้อนกลับ</a>';
                                        echo '<button type="submit" name="submit" class="btn btn-primary text-uppercase px-4">บันทึกข้อมูล</button>';
                                    } else {
                                        echo '<input type="hidden" name="fst" value="capappend">';
                                        echo '<button type="submit" name="submit" class="btn btn-primary text-uppercase px-5">ลงทะเบียน</button>';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        <?php
        }


        // * display course assignment to teacher or open course activation secondary teacher
        function cas_form($cap_info, $user_info)
        {
            global $fnc, $MJU_API, $api_person_faculty;
        ?>
            <div class="container border-bottom mb-4">
                <h2 class="text-success bold my-5">เพิ่มผู้สอนร่วม</h2>
                <form action="db_mgt.php" method="post" class="mt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-5 col-md-7 title h3 text-primary">
                            <p class="h3 text-secondary"><?= $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . ' ' . $cap_info["cap_notes"]; ?></p>
                            <p class="mb-2" style="font-size: 0.65em;"><?= $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lec"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ' )'; ?>
                                <hr><span class=""><?= 'ภาคการศึกษาที่ ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . ''; ?></span>
                            </p>
                            <p class="h3 mt-5 text-secondary"><?= 'อาจารย์เจ้าของวิชา'; ?></p>
                            <p style="font-size: 0.65em;"><?= $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></p>
                        </div>
                        <div class="col-7 col-md-5 form-group">
                            <?php
                            $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                            $fnc->debug_console("teacher list : ", $teacher_list);
                            ?>
                            <label for="teacher" class="form-label">เลือกผู้สอนร่วม</label>
                            <select id="teacher" name="teacher" class="form-select form-select-lg" size="10" aria-label="size 3 select example" required>
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                // * get teacher assistant list
                                $sql_cas = "SELECT cas_citizenid FROM course_active_secondary WHERE cap_id = " . $cap_info["cap_id"] . " AND cas_status like 'enable'";
                                $cas_ta = $fnc->get_db_array($sql_cas);
                                $fnc->debug_console("cas form - cas_ta list : ", $cas_ta);
                                foreach ($teacher_list as $t_list) {
                                    // if course owner not display
                                    if ($cap_info["cap_citizenid"] != $t_list["citizenId"]) {
                                        // if cas_ta have list
                                        $dupplicated = false;
                                        if (is_array($cas_ta)) {
                                            foreach ($cas_ta as $ta) {
                                                if ($ta["cas_citizenid"] == $t_list["citizenId"]) {
                                                    $dupplicated = true;
                                                }
                                            }
                                        }
                                        if ($dupplicated === false) {
                                            echo '<option value="' . $t_list["citizenId"] . '"';
                                            echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">


                    </div>

                    <div class="row">
                        <div class="col-3 offset-6 text-right mb-5">
                            <a href="?p=courseview&cap_cid=<?= $cap_info["course_id"] ?>&cap_id=<?= $cap_info["cap_id"] ?>" target="_top" class="btn btn-secondary text-uppercase px-2 w-100">close</a>
                        </div>
                        <div class="col-3 text-right mb-5">
                            <input type="hidden" name="cap_id" value="<?= $cap_info["cap_id"] ?>">
                            <input type="hidden" name="course_id" value="<?= $cap_info["course_id"] ?>">
                            <input type="hidden" name="fst" value="casappend">
                            <button type="submit" name="ta_submit" value="ta_submit" class="btn btn-primary text-uppercase px-2 w-100">ลงทะเบียนสอนร่วม</button>
                        </div>
                    </div>

                </form>
            </div>
        <?php
        }
        ?>

        <?php
        // * display table cap
        function cap_table()
        {
            global $fnc, $MJU_API, $api_person;
        ?>
            <div class="container border-bottom mb-4">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <p class="text-primary h3">วิชาที่ลงทะเบียน</p>
                    </div>
                    <div class="col-md-3">
                        <form action="?" method="get" class="mt-4">
                            <div class="row gx-2">
                                <div class="col-6 form-group">
                                    <label for="semester" class="form-label">ภาคการศึกษา</label>
                                    <select id="semester" name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if (isset($_GET["semester"]) && $_GET["semester"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="edu_year" class="form-label">ปีการศึกษา</label>
                                    <select id="edu_year" name="edu_year" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if (isset($_GET["edu_year"]) && $_GET["edu_year"] == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-hover mb-0">
                    <thead class="thead-inverse">
                        <tr class="table-secondary">
                            <th class="text-center py-3">ภาคการศึกษา</th>
                            <th class="py-3">ชื่อวิชา</th>
                            <th class="py-3" colspan="2">เจ้าของวิชา</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET["semester"]) && isset($_GET["edu_year"])) {
                            $sql = "SELECT * FROM v_cap Where cap_semester = " . $_GET["semester"] . " AND cap_year = '" . $_GET["edu_year"] . "' order by cap_year Desc, cap_semester Desc, course_code_th, cap_notes";
                        } else {
                            $sql = "SELECT * FROM v_cap order by cap_year Desc, cap_semester Desc, course_code_th, cap_notes";
                        }
                        $cap_list = $fnc->get_db_array($sql);
                        $fnc->debug_console("cap list sql:", $sql);
                        $fnc->debug_console("cap list:", $cap_list);
                        if (!empty($cap_list)) {
                            foreach ($cap_list as $cap) {
                        ?>
                                <!-- <tr class="" onclick="window.open('?cap_id=<?= $cap['cap_id'] ?>','_top');"> -->
                                <tr>
                                    <td scope="row" class="text-center"><?= $cap["cap_semester"] . '/' . $cap["cap_year"]; ?></td>
                                    <td><a href="cap.php?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                            <?php if (!empty($cap["course_credit"])) {
                                                echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                                            } ?>
                                        </a></td>
                                    <?php
                                    $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                    ?>
                                    <td><a href="cap.php?p=userview&cap_uid=<?= $cap["cap_citizenid"]; ?>"><?= $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></a></td>
                                    <td class="text-end"><a href="cap.php?p=capedit&cap_id=<?= $cap["cap_id"]; ?>" target="_top" class="btn btn-warning btn-sm text-uppercase w-100">แก้ไขข้อมูล</a></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '
                        <tr>
                                <td scope="row" class="text-center" colspan="4">ไม่พบข้อมูล</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }

        function teacher_report($semester, $edu_year, $uid = NULL)
        {
            global $fnc, $MJU_API, $api_person_faculty;


            $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
            $fnc->debug_console("teacher list : ", $teacher_list);
            foreach ($teacher_list as $teacher) {
                $sql = "SELECT count(`teaching_load_citizenid`) as cnt_id FROM `teaching_load` WHERE `teaching_load_citizenid` = '" . $teacher["citizenId"] . "' AND `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
                if (empty($fnc->get_db_col($sql))) {
                    $sql_insert = "INSERT INTO `teaching_load` (`teaching_load_citizenid`, `teaching_load_titlePosition`, `teaching_load_firstName`, `teaching_load_lastName`, `teaching_load_semester`, `teaching_load_edu_year`, `teaching_load_lastupdate`) 
                    VALUES ('" . $teacher["citizenId"] . "', '" . $teacher["titlePosition"] . "', '" . $teacher["firstName"] . "', '" . $teacher["lastName"] . "', " . $semester . ", '" . $edu_year . "', current_timestamp())";
                    $fnc->sql_execute($sql_insert);
                }
            }


            $sql_cap = "Select coap.cap_citizenid, Sum(coap.cap_lecture_hours) As Sum_cap_lecture_hours, Sum(coap.cap_lab_hours) As Sum_cap_lab_hours From course_active_primary coap 
            Where coap.cap_semester = $semester And coap.cap_year = '$edu_year' And coap.cap_status = 'enable' Group By coap.cap_citizenid";
            $sql_cas = "Select coas.cas_citizenid, Sum(coas.cas_lecture_hours) As Sum_cas_lecture_hours, Sum(coas.cas_lab_hours) As Sum_cas_lab_hours From course_active_secondary coas Left Join course_active_primary coap On coas.cap_id = coap.cap_id 
            Where coas.cas_status = 'enable' And coap.cap_semester = $semester And coap.cap_year = '$edu_year' And coap.cap_status = 'enable'Group By coas.cas_citizenid";
            $cap_work_hour = $fnc->get_db_array($sql_cap);
            $cas_work_hour = $fnc->get_db_array($sql_cas);
            if (!empty($cas_work_hour)) {
                // print_r($cap_work_hour);
                // echo "<hr>";
                // print_r($cas_work_hour);
                // echo "<hr>";
                foreach ($cas_work_hour as $cas) {
                    $i = 0;
                    foreach ($cap_work_hour as $cap) {
                        if (array_search($cas["cas_citizenid"], $cap)) {
                            // echo $i . "<br>";
                            $cap_work_hour[$i]["Sum_cap_lecture_hours"] += $cas["Sum_cas_lecture_hours"];
                            $cap_work_hour[$i]["Sum_cap_lab_hours"] += $cas["Sum_cas_lab_hours"];
                        }
                        $i++;
                    }
                }
                // print_r($cap_work_hour);
                // echo "<hr>";
                $sql_update = "";
                foreach ($cap_work_hour as $cap) {
                    $sql_update .= "UPDATE `teaching_load` SET `teaching_load_lec_hours`=" . $cap["Sum_cap_lecture_hours"] . ",`teaching_load_lab_hours`=" . $cap["Sum_cap_lab_hours"] . ",`teaching_load_lastupdate`=current_timestamp() WHERE `teaching_load_citizenid` = '" . $cap["cap_citizenid"] . "' AND `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'; ";
                    // echo "<br>" . $sql_update . "<br>";
                }
                $fnc->sql_execute_multi($sql_update);
            }


        ?>
            <div class="container border-bottom mb-4">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <p class="text-primary h3">สรุปภาระงานสอนคณาจารย์ (<?= $semester ?>/<?= $edu_year ?>)</p>
                    </div>
                    <div class="col-md-3">
                        <form action="?" method="get" class="mt-4">
                            <div class="row gx-2">
                                <div class="col-6 form-group">
                                    <input type="hidden" name="p" value="<?= $_GET["p"] ?>">
                                    <label for="semester" class="form-label">ภาคการศึกษา</label>
                                    <select id="semester" name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <?php
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if (isset($semester) && $semester == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="edu_year" class="form-label">ปีการศึกษา</label>
                                    <select id="edu_year" name="edu_year" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <?php
                                        for ($i = date("Y") + 543 + 1; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if (isset($edu_year) && $edu_year == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-hover responsive">
                    <thead class="thead-inverse">
                        <tr class="table-secondary">
                            <th class="text-center py-3">#</th>
                            <th class="py-3">อาจารย์</th>
                            <th class="py-3 text-center">ภาคบรรยาย</th>
                            <th class="py-3 text-center">ภาคปฏิบัติ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `teaching_load` WHERE `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
                        $work_hour = $fnc->get_db_array($sql);
                        if (!empty($work_hour)) {
                            $i = 1;
                            foreach ($work_hour as $wh) {
                        ?>
                                <tr>
                                    <td scope="row" class="text-center"><?= $i; ?></td>
                                    <td><a href="cap.php?p=userview&cap_uid=<?= $wh["teaching_load_citizenid"]; ?>"><?= $fnc->gen_titlePosition_short($wh["teaching_load_titlePosition"]) . $wh["teaching_load_firstName"] . '&nbsp;&nbsp;' . $wh["teaching_load_lastName"]; ?></a></td>
                                    <td class="text-center"><?= $wh["teaching_load_lec_hours"] ?></td>
                                    <td class="text-center"><?= $wh["teaching_load_lab_hours"] ?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        } else {
                            echo '
                            <tr>
                                <td scope="row" class="text-center" colspan="4">ไม่พบข้อมูล</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="text-end text-mute" style="font-size: 0.9em;">ข้อมูล ณ วันที่ <?= $fnc->get_date_semi_th() . " (" . $fnc->get_time_th() . ")"; ?></div>
            </div>
        <?php
        }

        function edit_course_primary($course_id, $cap_id = NULL)
        {
            global $fnc;
            $sql = "SELECT * FROM `course` WHERE `course_id` =" . $course_id;
            $course_info = $fnc->get_db_row($sql);
            $fnc->debug_console("course info:", $course_info);
        ?>
            <div class="container border-bottom mb-4">
                <p class="text-primary h3">แก้ไขข้อมูลรายวิชา</p>
                <form action="db_mgt.php" method="post">
                    <div class="card bordered p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-4 form-group">
                                <label for="course_code_th" class="form-label text-capitalize">รหัสวิชา</label>
                                <input type="text" name="course_code_th" id="course_code_th" class="form-control" maxlength="5" placeholder="ภท111" value="<?= $course_info["course_code_th"]; ?>" required>
                            </div>
                            <div class="col-8 form-group">
                                <label for="course_name_th" class="form-label text-capitalize">ชื่อรายวิชา</label>
                                <input type="text" name="course_name_th" id="course_name_th" class="form-control" maxlength="80" placeholder="เขียนแบบก่อสร้างภูมิทัศน์" value="<?= $course_info["course_name_th"]; ?>" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-4 form-group">
                                <label for="course_code_en" class="form-label text-capitalize">Course Code</label>
                                <input type="text" name="course_code_en" id="course_code_en" class="form-control" maxlength="5" placeholder="LT111" value="<?= $course_info["course_code_en"]; ?>">
                            </div>
                            <div class="col-8 form-group">
                                <label for="course_name_en" class="form-label text-capitalize">Course Name</label>
                                <input type="text" name="course_name_en" id="course_name_en" class="form-control" maxlength="80" placeholder="Construction Design" value="<?= $course_info["course_name_en"]; ?>">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_credit" class="form-label text-capitalize">หน่วยกิต</label>
                                <input type="number" name="course_credit" id="course_credit" class="form-control text-center" max="20" value="<?= $course_info["course_credit"]; ?>" required>
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_lec" class="form-label text-capitalize">ภาคบรรยาย</label>
                                <input type="number" name="course_lec" id="course_lec" class="form-control text-center" max="10" value="<?= $course_info["course_lec"]; ?>" required>
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_lab" class="form-label text-capitalize">ภาคปฏิบัติ</label>
                                <input type="number" name="course_lab" id="course_lab" class="form-control text-center" max="10" value="<?= $course_info["course_lab"]; ?>" required>
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_self" class="form-label text-capitalize">ศึกษาตัวตนเอง</label>
                                <input type="number" name="course_self" id="course_self" class="form-control text-center" max="10" value="<?= $course_info["course_self"]; ?>" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3 form-group align-self-center text-center">
                                <label for="course" class="form-label text-capitalize text-primary h5">ตัวคูณ (Hrs.)</label>
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_lec_hrs" class="form-label text-capitalize">ภาคบรรยาย</label>
                                <input type="number" name="course_lec_hrs" id="course_lec_hrs" class="form-control text-center" max="45" value="<?= $course_info["course_lec_hrs"]; ?>">
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_lab_hrs" class="form-label text-capitalize">ภาคปฏิบัติ</label>
                                <input type="number" name="course_lab_hrs" id="course_lab_hrs" class="form-control text-center" max="45" value="<?= $course_info["course_lab_hrs"]; ?>">
                            </div>
                            <div class="col-6 col-md-3 form-group">
                                <label for="course_self_hrs" class="form-label text-capitalize">ศึกษาตัวตนเอง</label>
                                <input type="number" name="course_self_hrs" id="course_self_hrs" class="form-control text-center" max="45" value="<?= $course_info["course_self_hrs"]; ?>">
                            </div>
                        </div>

                        <div class="row g-3 mt-4 mb-3 text-end">
                            <div class="col-3 text-left">
                                <div class="form-check form-switch form-group">
                                    <input class="form-check-input form-control-lg align-self-end" type="checkbox" name="course_status" value="enable" id="course_status "<?php if ($course_info["course_status"] == "enable") { echo ' checked'; } ?>>
                                    <label class="form-check-label" for="course_status ">Open this course</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 offset-md-5 form-group">
                                <a href="?p=courseview&cap_cid=<?= $course_info["course_id"] ?>&cap_id=<?= $_GET["cap_id"] ?>" target="_top" name="submit" class="btn btn-lg btn-secondary px-4 w-100 text-capitalize">close</a>
                            </div>
                            <div class="col-6 col-md-2 form-group">
                                <input type="hidden" name="course_id" value="<?= $course_info["course_id"] ?>">
                                <input type="hidden" name="cap_id" value="<?= $_GET["cap_id"] ?>">
                                <input type="hidden" name="fst" value="courseupdate">
                                <input type="submit" name="courseupdate" value="บันทึก" class="btn btn-lg btn-primary px-4 w-100">
                            </div>
                        </div>
                    </div>
                </form>


            </div>

        <?php
        }
        ?>

        <div class="container">
            <nav class="nav justify-content-end">
                <a class="nav-link active" href="?">เปิดวิชาสอน</a>
                <a class="nav-link" href="?p=teacherreport&semester=1&edu_year=2565">ภาระงานสอน</a>
                <a class="nav-link" href="#">ออกจากระบบ</a>
            </nav>
        </div>

        <?php

        if (isset($_GET["p"]) && $_GET["p"] != "") {
            switch ($_GET["p"]) {
                case "capadd":
                    cap_form();
                    break;
                case "capedit":
                    if (isset($_GET["cap_id"])) {
                        cap_form();
                    }
                    break;
                case "courseview":
                    if (isset($_GET["cap_cid"]) && isset($_GET["cap_id"])) {
                        view_course_primary();
                    }
                    break;
                case "courseedit":
                    if (isset($_GET["cap_cid"]) && isset($_GET["cap_id"])) {
                        // view_course_primary();
                        edit_course_primary($_GET["cap_cid"], $_GET["cap_id"]);
                    }
                    break;
                case "userview":
                    if (isset($_GET["cap_uid"])) {
                        view_user();
                    }
                    break;
                case "teacherreport":
                    if (isset($_GET["semester"]) && isset($_GET["edu_year"])) {
                        teacher_report($_GET["semester"], $_GET["edu_year"]);
                    }
                    break;
            }
        } else {
            cap_form();
            cap_table();
        }

        // if (isset($_POST["submit"]) && isset($_POST["course"]) && isset($_POST["teacher"])) {
        //     cap_append();
        // } elseif (isset($_POST["ta_submit"])) {
        //     cas_append();
        // } elseif (isset($_GET["cap_uid"])) {
        //     view_user();
        // } elseif (isset($_GET["cap_cid"]) && isset($_GET["p"]) && $_GET["p"] == "courseview") {
        //     view_course_primary();
        // } elseif (isset($_GET["p"]) && $_GET["p"] == "capedit") {
        //     cap_form();
        // } elseif (isset($_GET["p"]) && $_GET["p"] == "teacherreport" && isset($_GET["semester"]) && isset($_GET["edu_year"])) {
        //     teacher_report($_GET["semester"], $_GET["edu_year"]);
        // } else {
        //     cap_form();
        //     cap_table();
        // }

        ?>




    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>