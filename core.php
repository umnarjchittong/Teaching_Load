<?php
session_start();
$_SESSION['coding_indent'] = 0;

ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

class Constants
{
    // public $google_analytic_id = 'G-62GTDQF33N';
    public $system_name = "Arch's Teaching Load System";
    public $system_org = "Arch@Maejo University";
    public $system_version = '1.0';
    // public $system_path = '/dev/TeachingLoad/';
    public $system_path = '/TeachingLoad/';
    public $system_debug = true;
    public $database_sample = false;
    public $cap_dupplicate_notes = array("(", ")");
    public $system_meta_refresh = 0; // default 3
    public $api_person_faculty = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
    public $api_person = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/";
    public $month_name = array(1 => "ม.ค.", 2 => "ก.พ.", 3 => "มี.ค.", 4 => "เม.ย.", 5 => "พ.ค.", 6 => "มิ.ย.", 7 => "ก.ค.", 8 => "ส.ค.", 9 => "ก.ย.", 10 => "ต.ค.", 11 => "พ.ย.", 12 => "ธ.ค.");
    public $month_fullname = array(1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม");
    public $auth_lv = array("1" => "guest", "3" => "member", "5" => "board", "7" => "officer", "9" => "developer");
    public $departments = array("การวางผังเมืองและสภาพแวดล้อม", "การออกแบบและวางแผนสิ่งแวดล้อม", "สถาปัตยกรรมศาสตร์", "ภูมิสถาปัตยกรรมศาสตร์", "เทคโนโลยีภูมิทัศน์");
    public $list_limit = 20;
    public $icon = array("search" => "bi-search", "close" => "bi-x-square", "add" => "bi-plus-square", "edit" => "bi-pencil-square", "del" => "bi-trash3", "save" => "bi-check-square", "person" => "bi-person-square", "person_add" => "bi-person-plus-fill", "person_del" => "bi-person-x-fill",);
}

class CommonFnc extends Constants
{
    public function debug_console($val1, $val2 = null)
    {
        if ($this->system_debug || $_SESSION["admin"]["auth_lv"] == 9) {
            if (is_array($val1)) {
                // $val1 = implode(',', $val1);
                $val1 = str_replace(
                    chr(34),
                    '',
                    json_encode($val1, JSON_UNESCAPED_UNICODE)
                );
                $val1 = str_replace(chr(58), chr(61), $val1);
                $val1 = str_replace(chr(44), ', ', $val1);
                $val1 = 'Array:' . $val1;
            }
            if (is_array($val2)) {
                // $val2 = implode(',', $val2);
                $val2 = str_replace(
                    chr(34),
                    '',
                    json_encode($val2, JSON_UNESCAPED_UNICODE)
                );
                $val2 = str_replace(chr(58), chr(61), $val2);
                $val2 = str_replace(chr(44), ', ', $val2);
                $val2 = 'Array:' . $val2;
            }
            if (isset($val1) && isset($val2) && !is_null($val2)) {
                echo '<script>console.log("' .
                    $val1 .
                    '\\n' .
                    $val2 .
                    '");</script>';
            } else {
                echo '<script>console.log("' . $val1 . '");</script>';
            }
        }
    }

    public function get_client_info()
    {
        $data = array();
        foreach ($_SERVER as $key => $value) {
            // $data .= '$_SERVER["' . $key . '"] = ' . $value . '<br />';
            array_push($data, '$_SERVER["' . $key . '"] = ' . $value);
        }
        return $data;
    }

    public function get_page_info($parameter = null)
    {
        if (!$parameter) {
            $indicesServer = [
                'PHP_SELF',
                'argv',
                'argc',
                'GATEWAY_INTERFACE',
                'SERVER_ADDR',
                'SERVER_NAME',
                'SERVER_SOFTWARE',
                'SERVER_PROTOCOL',
                'REQUEST_METHOD',
                'REQUEST_TIME',
                'REQUEST_TIME_FLOAT',
                'QUERY_STRING',
                'DOCUMENT_ROOT',
                'HTTP_ACCEPT',
                'HTTP_ACCEPT_CHARSET',
                'HTTP_ACCEPT_ENCODING',
                'HTTP_ACCEPT_LANGUAGE',
                'HTTP_CONNECTION',
                'HTTP_HOST',
                'HTTP_REFERER',
                'HTTP_USER_AGENT',
                'HTTPS',
                'REMOTE_ADDR',
                'REMOTE_HOST',
                'REMOTE_PORT',
                'REMOTE_USER',
                'REDIRECT_REMOTE_USER',
                'SCRIPT_FILENAME',
                'SERVER_ADMIN',
                'SERVER_PORT',
                'SERVER_SIGNATURE',
                'PATH_TRANSLATED',
                'SCRIPT_NAME',
                'REQUEST_URI',
                'PHP_AUTH_DIGEST',
                'PHP_AUTH_USER',
                'PHP_AUTH_PW',
                'AUTH_TYPE',
                'PATH_INFO',
                'ORIG_PATH_INFO',
            ];

            // $data = '<table cellpadding="10">';
            $val = "page info : \\n";
            foreach ($indicesServer as $arg) {
                if (isset($_SERVER[$arg])) {
                    // $data .= '<tr><td>' .
                    //     $arg .
                    //     '</td><td>' .
                    //     $_SERVER[$arg] .
                    //     '</td></tr>';
                    // $this->debug_console($arg . " = " . $_SERVER[$arg]);
                    $val .= $arg . ' = ' . $_SERVER[$arg] . "\\n";
                } else {
                    // $data .= '<tr><td>' . $arg . '</td><td>-</td></tr>';
                    // $this->debug_console($arg . " = -");
                    $val .= $arg . ' = -' . "\\n";
                }
            }
            // $data .= '</table>';            
            $this->debug_console($val);
            return $val;
        } else {
            switch ($parameter) {
                case 'thisfilename':
                    if (strripos($_SERVER['PHP_SELF'], '/')) {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/') + 1
                        );
                    } else {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/')
                        );
                    }
                    // $this->debug_console("this file name = " . $data);
                    return $data;
                    break;
                case 'parameter':
                    if (strripos($_SERVER['REQUEST_URI'], '?')) {
                        parse_str(
                            substr(
                                $_SERVER['REQUEST_URI'],
                                strripos($_SERVER['REQUEST_URI'], '?') + 1
                            ),
                            $data
                        );
                    } else {
                        parse_str(substr($_SERVER['REQUEST_URI'], 0), $data);
                    }
                    // print_r($data);
                    return $data;
                    break;
            }
        }
    }

    public function get_url_filename($val = true)
    {
        if ($val === true) {
            $val = $_SERVER['PHP_SELF'];
        }
        if (isset($val)) {
            if (strpos($val, '?')) {
                $val = substr($val, 0, strpos($val, '?'));
            }

            if (stristr($val, '/')) {
                $val = substr($val, strripos($val, '/') + 1);
            } else {
                $val = substr($val, strripos($val, '/'));
            }
            return $val;
        }
    }

    public function get_url_parameter($val = true, $data_array = false)
    {
        if ($val === true) {
            $val = $_SERVER['REQUEST_URI'];
        }
        if (isset($val) && stristr($val, '?')) {
            if (isset($data_array) && $data_array === true) {
                parse_str(substr($val, strpos($val, '?') + 1), $data);
                // print_r($data);
            } else {
                $data = substr($val, strpos($val, '?') + 1);
            }
            return $data;
        }
    }

    public function gen_google_analytics($id = null)
    {
        if (!isset($id) || $id != '') {
            $id = $this->google_analytic_id;
        }
        echo '<!-- Global site tag (gtag.js) - Google Analytics -->';
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' .
            $id .
            '"></script>';
        echo '<script>';
        echo '  window.dataLayer = window.dataLayer || [];';
        echo '  function gtag(){dataLayer.push(arguments);}';
        echo '  gtag("js", new Date());';
        echo '  gtag("config", "' . $id . '");';
        echo '</script>';
    }

    public function get_time_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = getdate(date("U"));
        }
        return $current_date["hours"] . ":" . $current_date["minutes"] . ":" . $current_date["seconds"] . " น.";
    }

    public function get_date_semi_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("j", strtotime($current_date));
        echo " ";
        echo $this->month_name[(int) date("m", strtotime($current_date))];
        echo " ";
        echo substr((date("Y", strtotime($current_date)) + 543), 2);
    }

    public function gen_date_range_semi_th($start_date, $end_date = "")
    {
        // echo date("M j, Y", strtotime($start_date));
        if (empty($end_date) || $end_date <= 0) {
            echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
        } else {
            if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
                if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
                    if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
                        echo date("j ", strtotime($start_date)) . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                    } else {
                        echo date("j", strtotime($start_date)) . date("-j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                    }
                } else {
                    echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . "-" . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                }
            } else {
                echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543) . "-" . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($end_date))] . " " . (date("Y", strtotime($end_date)) + 543);
            }
        }
    }

    public function gen_date_semi_en($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("M j, Y", strtotime($current_date));
    }

    public function gen_date_range_semi_en($start_date, $end_date = "")
    {
        // echo date("M j, Y", strtotime($start_date));
        if (empty($end_date) || $end_date <= 0) {
            echo date("M j, Y", strtotime($start_date));
        } else {
            if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
                if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
                    if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
                        echo date("M j, Y", strtotime($start_date));
                    } else {
                        echo date("M j", strtotime($start_date)) . date("-j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
                    }
                } else {
                    echo date("M j", strtotime($start_date)) . date("-M j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
                }
            } else {
                echo date("M j, Y", strtotime($start_date)) . date("-M j, Y", strtotime($end_date));
            }
        }
    }

    public function get_date_full_thai($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        $data = date("j", strtotime($current_date));
        $data .= " ";
        $data .= $this->month_fullname[(int) date("m", strtotime($current_date))];
        $data .= " ";
        $data .= (date("Y", strtotime($current_date)) + 543);
        return $data;
    }

    public function gen_date_full_thai($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("j", strtotime($current_date));
        echo " ";
        echo $this->month_fullname[(int) date("m", strtotime($current_date))];
        echo " ";
        echo (date("Y", strtotime($current_date)) + 543);
    }

    public function get_fiscal_year($date = NULL)
    {
        if ($date == NULL) {
            $date = date('Y-m-d H:i:s');
        }
        // echo "date= " . $date;
        // echo ", month= " . $date_m = date("m", strtotime($date));
        // echo ", year= " . $date_y = (date("Y", strtotime($date))+543);
        if (date("m", strtotime($date)) >= 10) {
            return (date("Y", strtotime($date)) + 543) + 1;
        }
        return (date("Y", strtotime($date)) + 543);
    }

    public function gen_alert($alert_sms, $alert_title = 'Alert!!', $alert_style = 'danger')
    {
        // echo '<div class="app-wrapper">';
        echo '<div class="container col-12 mt-3">';
        // echo '<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">';
        echo '<div class="alert alert-' . $alert_style . ' alert-dismissible fade show" role="alert">';
        echo '<div class="inner">';
        echo '<div class="app-card-body p-3 p-lg-4">';
        echo '<h3 class="mb-3 text-' .
            $alert_style .
            '">' .
            $alert_title .
            '</h3>';
        echo '<div class="row gx-5 gy-3">';
        echo '<div class="col-12">';
        echo '<div class="text-center">' . $alert_sms . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        // echo '</div>';
        $this->debug_console($alert_sms);
    }

    public function get_alert($method)
    {
        switch ($method) {
            case "replied":
                $this->gen_alert("ทำการส่งอีเมลตอบกลับเรียบร้อย.", "Email Sent", "info");
        }
    }

    public function date_diff($date1)
    {
        $date1 = date_create($date1);
        $date2 = date_create(date("Y") . "-" . date("m") . "-" . date("d"));
        $diff = date_diff($date2, $date1);
        //echo $diff->format("%R%a days");
        //        $this->debug_console($diff->format("%R%a"));
        if ($diff->format("%R%a") < 0) {
            //            $this->debug_console("false");
            // return false;
        } else {
            // $this->debug_console("true: " . $diff->format("%R%a"));
            //            $this->debug_console("true");
            // return $diff->format("%R%a");
            return true;
        }
    }

    public function get_time_ago($time)
    {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        // $condition = array(
        //     12 * 30 * 24 * 60 * 60 =>  'year',
        //     30 * 24 * 60 * 60       =>  'month',
        //     24 * 60 * 60            =>  'day',
        //     60 * 60                 =>  'hour',
        //     60                      =>  'minute',
        //     1                       =>  'second'
        // );
        $condition = array(
            12 * 30 * 24 * 60 * 60 =>  'yr',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hr',
            60                      =>  'min',
            1                       =>  'sec'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                // return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
                return '' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public function gen_titlePosition_short($titlePosition)
    {
        $titlePosition = str_replace('รองศาสตราจารย์ ', 'รศ.', $titlePosition);
        $titlePosition = str_replace('รองศาสตราจารย์', 'รศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์ ', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์ ', 'ศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์', 'ศ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์ ', 'อ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์', 'อ.', $titlePosition);
        return trim($titlePosition);
    }
}

class database extends CommonFnc
{
    protected $mysql_server = "10.1.3.5:3306";
    protected $mysql_user = "teachingload";
    protected $mysql_pass = "faedadmin";
    protected $mysql_name = "faed_teachingload";

    public function open_conn()
    {
        // $conn = mysqli_connect('10.1.3.5', 'faed_ddm', 'faedadmin', 'faed_ddm');        
        // $conn = new mysqli($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
        //$conn = new mysqli("10.1.3.5:3306","rims","faedamin","research_rims");
        if ($this->database_sample) {
            $mysql_name = "alumni_sample";
        }
        $conn = mysqli_connect($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
        if (mysqli_connect_errno()) {
            // die("Failed to connect to MySQL: " . mysqli_connect_error());
            $this->debug_console("MySQL Error!" . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    public function get_result($sql)
    {
        $result = $this->open_conn()->query($sql);
        return $result;
    }

    public function sql_execute($sql)
    {
        //$this->open_conn()->query($sql);
        $conn = $this->open_conn();
        $conn->query($sql);
        return $conn->insert_id;
    }

    public function sql_execute_multi($sql)
    {
        $conn = $this->open_conn();
        $conn->multi_query($sql);
    }

    public function sql_execute_debug($st = "", $sql)
    {
        if ($st != "") {
            if ($st == "die") {
                $this->debug_console("SQL: " . $sql);
            } else {
                $this->debug_console("SQL: " . $sql);
            }
        } else {
            //$this->open_conn()->query($sql);
            $conn = $this->open_conn();
            $conn->query($sql);
            return $conn->insert_id;
        }
    }

    public function sql_secure_string($str)
    {
        return mysqli_real_escape_string($this->open_conn(), $str);
    }

    public function get_db_row($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {;
                return $result->fetch_assoc();
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_rows($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {;
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_col_name($sql)
    {
        if (isset($sql)) {
            // $column = array("name", "orgname", "table", "orgtable", "def", "db", "catalog", "max_length", "length", "charsetnr", "flags", "type", "decimals");
            $column = array();
            $result = $this->get_result($sql);
            while ($col = $result->fetch_field()) {
                array_push($column, $col->name);
            }
            return $column;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_array($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            // $this->debug_console("496" . $sql);
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_dataset_array($sql, $method = "MYSQLI_NUM")
    {
        // * method = MYSQLI_NUM, MYSQLI_ASSOC, MYSQLI_BOTH
        return $this->open_conn()->query($sql)->fetch_all(MYSQLI_BOTH);
    }

    // public function get_dataset_array($sql)
    // {
    //     $dataset = array();
    //     if (isset($sql)) {
    //         $result = $this->get_result($sql);
    //         if ($result->num_rows > 0) {
    //             while ($row = $result->fetch_array()) {
    //                 array_push($dataset, array($row[0], $row[1]));
    //             }
    //             return $dataset;
    //         }
    //         //return NULL;
    //     } else {
    //         die("fnc get_db_col no sql parameter.");
    //     }
    // }

    public function get_db_col($sql)
    {
        if (isset($sql)) {
            //echo $this->debug("", "fnc get_db_col sql: " . $sql);
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_array();
                return $row[0];
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        return $this->get_db_col($sql);
    }
}

class Thailand_Province extends CommonFnc
{


    public function open_conn_thailand()
    {
        $mysql_server = "10.1.3.5:3306";
        $mysql_user = "alumni";
        $mysql_pass = "faedadmin";
        $mysql_db = "thailand";
        $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
        if (mysqli_connect_errno()) {
            // die("Failed to connect to MySQL: " . mysqli_connect_error());
            $this->debug_console("MySQL Error!" . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    public function get_province_subdistrict($SubDistrictID = NULL)
    {
        $sql = "Select 
        dis.zip_code As zipcode, 
        dis.name_th As subdistrict_name_th, dis.name_en As subdistrict_name_en, 
        amp.name_th As district_name_th, amp.name_en As district_name_en, 
        pro.name_th As province_name_th, pro.name_en As province_name_en, 
        geo.name As geocity_name_th
        From districts dis Left Join amphures amp On amp.id = dis.amphure_id Left Join provinces pro On pro.id = amp.province_id Left Join geographies geo On geo.id = pro.geography_id
        Where dis.id = " . $SubDistrictID;
        $query = mysqli_query($this->open_conn_thailand(), $sql);
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function gen_province_dropdown_form()
    {
        $sql = "SELECT * FROM provinces ORDER BY name_th";
        $query = mysqli_query($this->open_conn_thailand(), $sql);
        echo '<form action="?provice=true" method="GET" class="col-10">';
        echo '<div class="form-row">
            <div class="form-group col-md-4 mb-2">
                <label for="province">จังหวัด</label>
                <select name="province_id" id="province" class="form-select">
                    <option value="">เลือกจังหวัด</option>';
        while ($result = mysqli_fetch_assoc($query)) :
            echo '
            <option value="' . $result['id'] . '">' . $result['name_th'] . '</option>';
        endwhile;
        echo '</select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="amphure">อำเภอ</label>
                <select name="amphure_id" id="amphure" class="form-select">
                    <option value="">เลือกอำเภอ</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="district">ตำบล</label>
                <select name="district_id" id="district" class="form-select">
                    <option value="">เลือกตำบล</option>
                </select>
            </div>
            <div class="form-group col-md-4 mb-2">
                <label for="zip">รหัสไปรษณีย์</label>
                <input type="text" name="zip" id="zip" class="form-control">                
            </div>
            <input type="hidden" id="subdistrict_code" name="subdistrict_code">
        </div>';
        echo '<button type="submit" id="submit_btn" name="submit_btn" class="btn btn-primary mt-3" disabled>Sending</button>';
        echo '</form>';
        echo '';
    }

    public function gen_provice_script_js()
    {
        echo "<script type=text/javascript>
        $(function(){
            var provinceObject = $('#province');
            var amphureObject = $('#amphure');
            var districtObject = $('#district');            
            
            // on change province
            provinceObject.on('change', function(){
                var provinceId = $(this).val();
                
                amphureObject.html('<option value=>เลือกอำเภอ</option>');
                districtObject.html('<option value=>เลือกตำบล</option>');
                
                $.get('get_thailand.php?province_id=' + provinceId, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        amphureObject.append(
                            $('<option></option>').val(item.id).html(item.name_th)
                        );
                    });
                });
            });
            
            // on change amphure
            amphureObject.on('change', function(){
                var amphureId = $(this).val();         
                districtObject.html('<option value=>เลือกตำบล</option>');
                
                $.get('get_thailand.php?amphure_id=' + amphureId, function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        districtObject.append(
                            $('<option></option>').val(item.id).html(item.name_th)
                        );
                    });
                });
            });
            
            // on change sub-district
            districtObject.on('change', function(){
                var districtId = $(this).val();
                
                $.get('get_thailand.php?district_id=' + districtId, function(data){
                    var result = JSON.parse(data);
                    document.getElementById('zip').value = result[0].zip_code;            
                    document.getElementById('subdistrict_code').value = result[0].id;                           
                });
                
                document.getElementById('submit_btn').disabled = false;
            });
        });
        </script>";
    }

    public function alumni_encode($AlumniInfo)
    {
        if ($AlumniInfo) {
            print_r($AlumniInfo);
            echo "<hr>";
            $s = dechex(substr($AlumniInfo["alumni_studentid"], 0, 5));
            $t = dechex(substr($AlumniInfo["alumni_studentid"], -5));
            $i = dechex(substr($AlumniInfo["alumni_citizenid"], 0, 5));
            $d = dechex(substr($AlumniInfo["alumni_citizenid"], -5));
            // $EmailAddSign = strpos($AlumniInfo["alumni_email"], "@");
            // echo $add_postition;
            $e = substr($AlumniInfo["alumni_email"], 0, strpos($AlumniInfo["alumni_email"], "@"));
            $m = substr($AlumniInfo["alumni_email"], - (strlen($AlumniInfo["alumni_email"]) - strpos($AlumniInfo["alumni_email"], "@") - 1));

            echo "<br>\$s = " . $s . " - " . hexdec($s);
            echo "<br>\$t = " . $t . " - " . hexdec($t);
            echo "<br>\$i = " . $i . " - " . hexdec($i);
            echo "<br>\$d = " . $d . " - " . hexdec($d);
            echo "<br>\$e = " . $e;
            echo "<br>\$m = " . $m;
            $AlumniActivateKey = array("d" => $d, "e" => $e, "i" => $i, "m" => $m, "s" => $s, "t" => $t);
            $AlumniActivateKey = json_encode($AlumniActivateKey);
            echo "<br>json:<br>" . $AlumniActivateKey;
            echo "<meta http-equiv='refresh' content='0.1; URL=province.php?activate=" . $AlumniActivateKey . "'>";
            // header("location:province.php?a=ok");
        }
    }

    public function alumni_decode($AlumniActivateKey)
    {
        $AlumniActivateKey = json_decode($AlumniActivateKey, true);
        // print_r($AlumniActivateKey);
        // echo "<br>\$s = " . $AlumniActivateKey["s"] . " - " . hexdec($AlumniActivateKey["s"]);
        // echo "<br>\$t = " . $AlumniActivateKey["t"] . " - " . hexdec($AlumniActivateKey["t"]);
        // echo "<br>\$i = " . $AlumniActivateKey["i"] . " - " . hexdec($AlumniActivateKey["i"]);
        // echo "<br>\$d = " . $AlumniActivateKey["d"] . " - " . hexdec($AlumniActivateKey["d"]);
        // echo "<br>\$e = " . $AlumniActivateKey["e"];
        // echo "<br>\$m = " . $AlumniActivateKey["m"];

        $sql = "Select var.* From v_alumni_regist var Where 
        var.alumni_citizenid Like '" . hexdec($AlumniActivateKey["i"]) . "%' And var.alumni_citizenid Like '%" . hexdec($AlumniActivateKey["d"]) . "' And 
        var.alumni_studentid Like '" . hexdec($AlumniActivateKey["s"]) . "%' And var.alumni_studentid Like '%" . hexdec($AlumniActivateKey["t"]) . "' And 
        var.alumni_email Like '" . $AlumniActivateKey["e"] . "%' And var.alumni_email Like '%" . $AlumniActivateKey["m"] . "'";

        // echo "<br>" . $sql . "<br>";
        $fnc = new Database;
        $AlumniInfo = $fnc->get_db_array($sql)[0];
        // print_r($AlumniInfo);
        return ($AlumniInfo);
    }

    public function alumni_activate_confirm($AlumniInfo)
    {
        $sql = "UPDATE v_alumni_registered SET std_api_status='enable' WHERE alumni_citizenid = '" . $AlumniInfo["alumni_citizenid"] . "' AND alumni_studentid = '" . $AlumniInfo["alumni_studentid"] . "' AND alumni_email = '" . $AlumniInfo["alumni_email"] . "'";
        $database = new Database;
        $database->sql_execute($sql);
        $database->debug_console("update regist enable completed");
    }
}

class Web extends database
{
    // * display course assignment to teacher or open course activation primary teacher
    public function cap_form()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;
        if (isset($_GET["p"]) && $_GET["p"] == "capedit" && isset($_GET["cap_id"])) {
            $title_text = "ปรับปรุงข้อมูลที่ลงทะเบียนไว้";
        } else {
            $title_text = "ลงทะเบียนวิชาที่เปิดสอน";
        }
?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_main bg-gradient">
                <h5><?= $title_text ?></h5>
            </div>
            <div class="container h-100 px-2 px-md-5 bg-light border rounded-top rounded-3 page_container_form">
                <?php
                if (isset($_GET["cap_id"])) {
                    $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                    $cap_info = $fnc->get_db_array($sql)[0];
                    $fnc->debug_console("cap filter sql: ", $sql);
                    $fnc->debug_console("cap filter array: ", $cap_info);
                    // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                }
                ?>
                <form action="../db_mgt.php" method="post" class="mt-4">

                    <div class="row form-group g-3 mb-3 text-dark">
                        <div class="col-6 col-md-5 col-lg-4 mb-3">
                            <div class="form-group">
                                <?php
                                // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                                // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
                                // foreach ($teacher_list as $t_list) {
                                //     echo $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . ' (' . $fnc->gen_titlePosition_short($t_list["titlePosition"]) . ')' . '<br>';
                                // }
                                $teacher_list = $fnc->get_db_array("SELECT citizenId, titleName, titlePosition, firstName, lastName FROM teacher ORDER BY firstName");
                                // $fnc->debug_console("teacher list : ", $teacher_list);
                                $teacher_ext = $fnc->get_db_array("SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName FROM teacher_ext ORDER BY firstName");
                                // $fnc->debug_console("teacher list : ", $teacher_ext);
                                $teacher_list = array_merge($teacher_list, $teacher_ext);
                                // $fnc->debug_console("teacher merge : ", $teacher_list);
                                ?>
                                <label for="teacher" class="form-label">เลือกผู้รับผิดชอบวิชา</label>
                                <select id="teacher" name="teacher" class="form-select form-select-sm" size="13" aria-label="size 3 select example" required>
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
                        <div class="col">
                            <div class="row mb-4">
                                <div class="col-6 form-group">
                                    <label for="semester" class="form-label">ภาคการศึกษา</label>
                                    <select id="semester" name="semester" class="form-select" aria-label="Default select example">
                                        <?php
                                        if (isset($cap_info["cap_semester"])) {
                                            $semester = $cap_info["cap_semester"];
                                        } elseif (!empty($_SESSION["admin"]["semester"])) {
                                            $semester = $_SESSION["admin"]["semester"];
                                        } elseif (!empty($_GET["semester"])) {
                                            $semester = $_GET["semester"];
                                        } else {
                                            $semester = 1;
                                        }
                                        for ($i = 1; $i <= 3; $i++) {
                                            echo '<option value="' . $i . '"';
                                            if ($semester == $i) {
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
                                        if (isset($cap_info["cap_year"])) {
                                            $edu_year = $cap_info["cap_year"];
                                        }
                                        if (!empty($_SESSION["admin"]["edu_year"])) {
                                            $edu_year = $_SESSION["admin"]["edu_year"];
                                        } elseif (!empty($_GET["edu_year"])) {
                                            $edu_year = $_GET["edu_year"];
                                        } else {
                                            $edu_year = (date("Y") + 543);
                                        }
                                        for ($i = date("Y") + 543; $i >= 2563; $i--) {
                                            echo '<option value="' . $i . '"';
                                            if ($edu_year == $i) {
                                                echo " selected";
                                            }
                                            echo '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 form-group mb-4">
                                <label for="department" class="form-label">หลักสูตร</label>
                                <select id="department" name="department" class="form-select">
                                    <?php
                                    foreach ($this->departments as $dept) {
                                        echo '<option value="' . $dept . '"';
                                        if (!empty($_GET["dept"]) && $_GET["dept"] == $dept) {
                                            echo " selected";
                                        }
                                        echo '>' . $dept . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 form-group mb-4">
                                <?php
                                // $sql = "SELECT course_id,course_code_th,course_name_th,course_credit,course_lec,course_lab,course_self FROM course WHERE course_status = 'enable'";
                                // $course_list = $fnc->get_dataset_array($sql);
                                ?>
                                <label for="course" class="form-label">ชื่อรายวิชา</label>
                                <input type="text" name="course" id="course" class="form-control" maxlength="80" placeholder="ภท111 เขียนแบบก่อสร้างภูมิทัศน์" <?php if (!empty($cap_info)) {
                                                                                                                                                                    echo ' value="' . $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . '"';
                                                                                                                                                                } ?>required>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6 col-lg-3 form-group">
                                    <label for="course_credit" class="form-label text-capitalize">หน่วยกิต <span class="lbl_required">*</span></label>
                                    <input type="number" name="course_credit" id="course_credit" class="form-control text-center" max="20" value="<?php if (isset($cap_info["course_credit"])) {
                                                                                                                                                        echo $cap_info["course_credit"];
                                                                                                                                                    } else {
                                                                                                                                                        echo "3";
                                                                                                                                                    } ?>" required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 form-group">
                                    <label for="course_lec" class="form-label text-capitalize">ภาคบรรยาย <span class="lbl_required">*</span></label>
                                    <input type="number" name="course_lec" id="course_lec" class="form-control text-center" max="10" value="<?php if (isset($cap_info["course_lec"])) {
                                                                                                                                                echo $cap_info["course_lec"];
                                                                                                                                            } else {
                                                                                                                                                echo "2";
                                                                                                                                            } ?>" required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 form-group">
                                    <label for="course_lab" class="form-label text-capitalize">ภาคปฏิบัติ <span class="lbl_required">*</span></label>
                                    <input type="number" name="course_lab" id="course_lab" class="form-control text-center" max="270" value="<?php if (isset($cap_info["course_lab"])) {
                                                                                                                                                    echo $cap_info["course_lab"];
                                                                                                                                                } else {
                                                                                                                                                    echo "3";
                                                                                                                                                } ?>" required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 form-group">
                                    <label for="course_self" class="form-label text-capitalize">ศึกษาตัวตนเอง <span class="lbl_required">*</span></label>
                                    <input type="number" name="course_self" id="course_self" class="form-control text-center" max="10" value="<?php if (isset($cap_info["course_self"])) {
                                                                                                                                                    echo $cap_info["course_self"];
                                                                                                                                                } else {
                                                                                                                                                    echo "5";
                                                                                                                                                } ?>" required>
                                </div>
                            </div>

                            <div class="text-end mt-5">
                                <?php
                                if (isset($_GET["cap_id"])) {
                                    echo '<input type="hidden" name="course_id" value="' . $cap_info["course_id"] . '">';
                                    echo '<input type="hidden" name="fst" value="capupdate">';
                                    echo '<input type="hidden" name="cap_id" value="' . $cap_info["cap_id"] . '">';
                                    echo '<button type="button" onclick=window.open("../db_mgt.php?p=course&act=capdelete&cap_id=' . $cap_info["cap_id"] . '","_top") class="btn btn-danger text-uppercase px-4 me-2">ยกเลิกรายวิชา</button>';
                                    echo '<button type="button" onclick=window.open("index.php","_top") class="btn btn-secondary text-uppercase px-4 me-2">ย้อนกลับ</button>';
                                    echo '<button type="submit" name="submit" class="btn btn-primary text-uppercase px-4">บันทึกข้อมูล</button>';
                                } else {
                                    echo '<input type="hidden" name="fst" value="capappend">';
                                    echo '<button type="submit" name="submit" class="btn btn-primary text-uppercase px-5 mt-md-4" data-bs-toggle="tooltip" data-bs-placement="top" title="ลงทะเบียนวิชา">ลงทะเบียน</button>';
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

    // * display teacher and assignment to curriculum
    public function curriculum_teacher_form()
    {
        $fnc = $this;
        $title_text = "จัดการอาจารย์ประจำหลักสูตร";
    ?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_teacher bg-gradient">
                <h5><?= $title_text ?></h5>
            </div>
            <div class="container px-1 px-md-4 bg-light text-dark border rounded-top rounded-3 page_container_form">
                <form action="?" method="get" class="mt-4">
                    <input type="hidden" name="p" value="<?= $_GET["p"] ?>">
                    <div class="row g-3 mt-3 mb-2 text-dark">
                        <div class="col-md-5 form-group">
                            <label for="departmentA" class="form-label">หลักสูตรต้นทาง</label>
                            <select id="departmentA" name="deptA" class="form-select" onchange="this.form.submit()">
                                <option value="">ไม่กำหนด</option>
                                <?php
                                // echo '<option value="" selected>โปรดเลือกหลักสูตร</option>';
                                foreach ($this->departments as $dept) {
                                    echo '<option value="' . $dept . '"';
                                    if (!empty($_GET["deptA"]) && $_GET["deptA"] == $dept) {
                                        echo " selected";
                                    }
                                    echo '>' . $dept . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="departmentB" class="form-label">หลักสูตรปลายทาง</label>
                            <select id="departmentB" name="deptB" class="form-select" onchange="this.form.submit()">
                                <option value="">ไม่กำหนด</option>
                                <?php
                                // echo '<option value="" selected>โปรดเลือกหลักสูตร</option>';
                                foreach ($this->departments as $dept) {
                                    if (isset($_GET["deptA"]) && $_GET["deptA"] != $dept) {
                                        echo '<option value="' . $dept . '"';
                                        if (!empty($_GET["deptB"]) && $_GET["deptB"] == $dept) {
                                            echo " selected";
                                        }
                                        echo '>' . $dept . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>

                <form action="../db_mgt.php" method="post" class="mt-4">
                    <div class="row g-3 mt-1 mb-4 text-dark">
                        <div class="col-md-5 form-group">
                            <label for="teacherA" class="form-label">อาจารย์สังกัดหลักสูตร</label>
                            <select id="teacherA" name="teacherA[]" class="form-select form-select" size="13" multiple required>
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                // $fnc->debug_console($teacher_list);
                                $teacher_list = "SELECT * FROM teacher WHERE department = '" . $_GET["deptA"] . "' ORDER BY firstName";
                                $teacher_list = $fnc->get_db_array($teacher_list);
                                // $fnc->debug_console("teacher: ", $teacher_list);
                                foreach ($teacher_list as $t_list) {
                                    echo '<option value="' . $t_list["citizenId"] . '">' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . " (" .  $fnc->gen_titlePosition_short($t_list["titlePosition"]) . ")" . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-2 align-self-center">
                            <div class="form-group">
                                <input type="hidden" name="fst" value="departmentAssign">
                                <input type="hidden" name="p" value="<?= $_GET["p"] ?>">
                                <input type="hidden" name="deptA" value="<?= $_GET["deptA"] ?>">
                                <input type="hidden" name="deptB" value="<?= $_GET["deptB"] ?>">
                                <button type="submit" name="btn_department" class="btn btn-primary text-uppercase w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="ย้ายรายชื่อต้นทาง ไป ปลายทาง">ย้าย<i class="bi bi-chevron-double-right ms-2"></i></button>
                                <!-- <button type="submit" name="btn_general" class="btn btn-success text-uppercase w-100 mt-4"><i class="bi bi-chevron-double-left me-2"></i>วิชาทั่วไป</button> -->
                            </div>
                        </div>

                        <div class="col-md-5 form-group">
                            <label for="teacherB" class="form-label">อาจารย์สังกัดหลักสูตร</label>
                            <select id="teacherB" name="teacherB" class="form-select form-select" size="13">
                                <!-- <option selected>Open this select menu</option> -->
                                <?php
                                // $fnc->debug_console($teacher_list);
                                $teacher_list = "SELECT * FROM teacher WHERE department = '" . $_GET["deptB"] . "' ORDER BY firstName";
                                $teacher_list = $fnc->get_db_array($teacher_list);
                                // $fnc->debug_console("teacher: ", $teacher_list);
                                foreach ($teacher_list as $t_list) {
                                    echo '<option value="' . $t_list["citizenId"] . '">' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . " (" .  $fnc->gen_titlePosition_short($t_list["titlePosition"]) . ")" . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    <?php
    }

    public function ext_teacher_form()
    {
        $fnc = $this;
        $title_text = "จัดการอาจารย์พิเศษ";
    ?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_teacher_ext bg-gradient">
                <h5><?= $title_text ?></h5>
            </div>
            <div class="container px-2 px-md-4 mb-4 bg-light text-dark border rounded-top rounded-3 page_container_form">
                <div class="row g-3 px-2 px-md-4 mb-3 text-dark">
                    <div class="col-12 col-md-6">
                        <form action="../db_mgt.php" method="post" class="mt-4">
                            <div class="col-12 mb-3 form-group">
                                <label for="citizenid" class="form-label">หมายเลขบัตรประจำตัวประชาชน/หนังสือเดินทาง</label>
                                <input type="text" class="form-control" id="citizenid" name="citizenid" maxlength="13" required>
                            </div>
                            <div class="row mb-3 form-group">
                                <div class="col-6 form-group">
                                    <label for="titleName" class="form-label">คำนำหน้า</label>
                                    <input type="text" class="form-control" id="titleName" name="titleName" maxlength="16" required>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="titlePosition" class="form-label">ตำแหน่งวิชาการ (ย่อ)</label>
                                    <input type="text" class="form-control" id="titlePosition" name="titlePosition" maxlength="30">
                                </div>
                            </div>
                            <div class="row mb-3 form-group">
                                <div class="col-6 form-group">
                                    <label for="firstName" class="form-label">ชื่อ</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" maxlength="30" required>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="lastName" class="form-label">นามสกุล</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" maxlength="30" required>
                                </div>
                            </div>
                            <div class="col-12 text-end mb-3 form-group">
                                <input type="hidden" name="fst" value="teacherExtAppend">
                                <button type="submit" name="submit" class="btn btn-primary text-uppercase px-3 mt-md-3" data-bs-toggle="tooltip" data-bs-placement="left" title="ลงทะเบียนอาจารย์พิเศษ">ลงทะเบียน<i class="bi bi-chevron-double-right ms-2"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-6">
                        <form action="../db_mgt.php" method="post" class="mt-4">
                            <div class="col-12 mb-3 form-group">
                                <label for="teacher" class="form-label">อาจารย์พิเศษในระบบ</label>
                                <select id="teacher" name="teacher" class="form-select form-select" size="13" required>
                                    <?php
                                    $teacher_list = "SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName, teacher_ext_status AS STATUS , teacher_ext_lastupdate AS lastupdate FROM teacher_ext ORDER BY lastupdate";
                                    $teacher_list = $fnc->get_db_array($teacher_list);
                                    // $fnc->debug_console("teacher: ", $teacher_list);
                                    foreach ($teacher_list as $t_list) {
                                        echo '<option value="' . $t_list["citizenId"] . '">' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . " (" .  $fnc->gen_titlePosition_short($t_list["titlePosition"]) . ")" . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 text-end mb-3 form-group">
                                <input type="hidden" name="fst" value="teacherExtDelete">
                                <button type="submit" name="btn_teacherExtDelete" class="btn btn-outline-danger text-uppercase px-3 mt-md-4" data-bs-toggle="tooltip" data-bs-placement="left" title="ลบข้อมูลอาจารย์พิเศษ">ลบข้อมูล X</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



    <?php
    }

    public function cap_form_ok()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;
        if (isset($_GET["p"]) && $_GET["p"] == "capedit" && isset($_GET["cap_id"])) {
            $title_text = "ปรับปรุงข้อมูลที่ลงทะเบียนไว้";
        } else {
            $title_text = "ลงทะเบียนวิชาที่จะเปิดสอน";
        }
    ?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_main">
                <h2 class="h3"><?= $title_text ?></h2>
            </div>
            <div class="container h-100 px-2 px-md-5 bg-light border rounded-top rounded-3">
                <?php
                if (isset($_GET["cap_id"])) {
                    $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                    $cap_info = $fnc->get_db_array($sql)[0];
                    $fnc->debug_console("cap filter sql: ", $sql);
                    $fnc->debug_console("cap filter array: ", $cap_info);
                    // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                }
                ?>
                <form action="../db_mgt.php" method="post" class="mt-4">

                    <div class="row form-group g-3 mb-3">
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <?php
                                // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                                // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
                                $teacher_list = $fnc->get_db_array("SELECT citizenId, titleName, titlePosition, firstName, lastName FROM teacher ORDER BY firstName");
                                // $fnc->debug_console("teacher list : ", $teacher_list);
                                $teacher_ext = $fnc->get_db_array("SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName FROM teacher_ext ORDER BY firstName");
                                // $fnc->debug_console("teacher list : ", $teacher_ext);
                                $teacher_list = array_merge($teacher_list, $teacher_ext);
                                // $fnc->debug_console("teacher merge : ", $teacher_list);
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
                                        for ($i = date("Y") + 543; $i >= 2563; $i--) {
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
                                    echo '<button type="button" onclick=window.open("../db_mgt.php?p=course&act=capdelete&cap_id=' . $cap_info["cap_id"] . '","_top") class="btn btn-danger text-uppercase px-4 me-2">ยกเลิกรายวิชา</button>';
                                    echo '<button type="button" onclick=window.open("index.php","_top") class="btn btn-secondary text-uppercase px-4 me-2">ย้อนกลับ</button>';
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

    public function table_teaching_load_sorting($sorting)
    {
        $fnc = $this;
        $page_parameter = $fnc->get_url_parameter();

        if (stripos($page_parameter, "&page=")) {
            $page_parameter = explode("&", $page_parameter);
            array_pop($page_parameter);
            $page_parameter = implode("&", $page_parameter);
        }
        $sorting["parameter"] = $page_parameter;
        if (stripos($page_parameter, "&sortby=")) {
            $page_parameter = explode("&", $page_parameter);
            array_pop($page_parameter);
            $page_parameter = implode("&", $page_parameter);
        }
        $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Atea';
        $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Alec';
        $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Alab';

        if (!isset($_GET['sortby'])) {
            $sorting["icon_teacher"] = $sorting["icon_a"];
            $sorting["sortby"] = " order by teaching_load_firstName";
            // $sorting["sortby"] = " order by teaching_load_lec_hours";
            $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ztea';
            // $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Alec';
            // $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Alab';
        } else {
            switch ($_GET['sortby']) {
                case "Atea":
                    $sorting["icon_teacher"] = $sorting["icon_a"];
                    $sorting["sortby"] = " order by teaching_load_firstName";
                    $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ztea';
                    // $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Alec';
                    // $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Alab';
                    break;
                case "Ztea":
                    $sorting["icon_teacher"] = $sorting["icon_z"];
                    $sorting["sortby"] = " order by teaching_load_firstName Desc";
                    // $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Atea';
                    // $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Alec';
                    // $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Alab';
                    break;
                case "Alec":
                    $sorting["icon_lec"] = $sorting["icon_a"];
                    $sorting["sortby"] = " order by teaching_load_lec_hours";
                    $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Zlec';
                    break;
                case "Zlec":
                    $sorting["icon_lec"] = $sorting["icon_z"];
                    $sorting["sortby"] = " order by teaching_load_lec_hours Desc";
                    $sorting["parameter_lec"] = $page_parameter . '&sortby=' . 'Alec';
                    break;
                case "Alab":
                    $sorting["icon_lab"] = $sorting["icon_a"];
                    $sorting["sortby"] = " order by teaching_load_lab_hours";
                    $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Zlab';
                    break;
                case "Zlab":
                    $sorting["icon_lab"] = $sorting["icon_z"];
                    $sorting["sortby"] = " order by teaching_load_lab_hours Desc";
                    $sorting["parameter_lab"] = $page_parameter . '&sortby=' . 'Alab';
                    break;
            }
        }
        return $sorting;
    }

    function teacher_report($semester, $edu_year, $uid = NULL)
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;

        // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
        // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
        // $fnc->debug_console("teacher list : ", $teacher_list);
        $teacher_list = $fnc->get_db_array("SELECT citizenId, titleName, titlePosition, firstName, lastName, department FROM teacher ORDER BY firstName");
        // $fnc->debug_console("teacher list : ", $teacher_list);
        $teacher_ext = $fnc->get_db_array("SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName, teacher_ext_status AS department FROM teacher_ext ORDER BY firstName");
        // $fnc->debug_console("teacher list : ", $teacher_ext);
        $teacher_list = array_merge($teacher_list, $teacher_ext);
        // $fnc->debug_console("teacher merge : ", $teacher_list);
        // print_r($teacher_list);
        foreach ($teacher_list as $teacher) {
            $sql = "SELECT count(`teaching_load_citizenid`) as cnt_id FROM `teaching_load` WHERE `teaching_load_citizenid` = '" . $teacher["citizenId"] . "' AND `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
            // $fnc->debug_console("sql find : " . $sql);
            if ($teacher["department"] == 'enable' || $teacher["department"] == 'delete' || $teacher["department"] == 'disable') {
                $teacher["department"] = 'อาจารย์พิเศษ';
            }
            if (empty($fnc->get_db_col($sql))) {
                $sql_insert = "INSERT INTO `teaching_load` (`teaching_load_citizenid`, `teaching_load_titlePosition`, `teaching_load_firstName`, `teaching_load_lastName`, `teaching_load_department`, `teaching_load_semester`, `teaching_load_edu_year`, `teaching_load_lastupdate`) 
                    VALUES ('" . $teacher["citizenId"] . "', '" . $teacher["titlePosition"] . "', '" . $teacher["firstName"] . "', '" . $teacher["lastName"] . "', '" . $teacher["department"] . "', " . $semester . ", '" . $edu_year . "', current_timestamp())";
                $fnc->sql_execute($sql_insert);
            }
        }

        $sql_cap = "Select coap.cap_citizenid, Sum(coap.cap_lecture_hours) As Sum_cap_lecture_hours, Sum(coap.cap_lab_hours) As Sum_cap_lab_hours From course_active_primary coap 
            Where coap.cap_semester = $semester And coap.cap_year = '$edu_year' And coap.cap_status = 'enable' Group By coap.cap_citizenid";
        $sql_cas = "Select coas.cas_citizenid, Sum(coas.cas_lecture_hours) As Sum_cas_lecture_hours, Sum(coas.cas_lab_hours) As Sum_cas_lab_hours From course_active_secondary coas Left Join course_active_primary coap On coas.cap_id = coap.cap_id 
            Where coas.cas_status = 'enable' And coap.cap_semester = $semester And coap.cap_year = '$edu_year' And coap.cap_status = 'enable' Group By coas.cas_citizenid";
        $cap_work_hour = $fnc->get_db_array($sql_cap);
        $cas_work_hour = $fnc->get_db_array($sql_cas);
        // $fnc->debug_console("sql_cap : " . $sql_cap);
        // $fnc->debug_console("sql_cas : " . $sql_cas);
        // echo $sql_cap . "<hr>";
        // print_r($cap_work_hour);
        // echo "<br><br>";
        // echo $sql_cas . "<hr>";
        // print_r($cas_work_hour);
        // die();
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

        $sorting = array(
            'sortby' => '', 'parameter' => '',
            'parameter_teacher' => '', 'icon_teacher' => '',
            'parameter_lec' => '', 'icon_lec' => '',
            'parameter_lab' => '', 'icon_lab' => '',
            'icon_a' => '<i class="bi bi-sort-alpha-down fw-bold ms-2" style="font-size: 1.2em;"></i>', 'icon_z' => '<i class="bi bi-sort-alpha-down-alt fw-bold ms-2" style="font-size: 1.2em;"></i>'
        );
        $sorting = $fnc->table_teaching_load_sorting($sorting);
        $fnc->debug_console("sorting: ", $sorting);

    ?>
        <div class="container border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-9 align-self-end">
                    <p class="text-warning h4">สรุปภาระงานสอนคณาจารย์ (<?= $semester ?>/<?= $edu_year ?>)</p>
                </div>
                <div class="col-md-3" style="font-size: 0.8em;">
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

            <table class="table table-striped table-bordered table-hover responsive table-light" style="font-size: 1.2em;">
                <thead class="thead-inverse">
                    <tr class="table-secondary">
                        <th class="text-center py-3">#</th>
                        <th class="py-3"><a href="<?= '?' . $sorting["parameter_teacher"] ?>" target="_top" style="text-decoration: none; color: #000;">อาจารย์<?= $sorting["icon_teacher"] ?></a></th>
                        <th class="py-3 text-center"><a href="<?= '?' . $sorting["parameter_lec"] ?>" target="_top" style="text-decoration: none; color: #000;">ภาคบรรยาย<?= $sorting["icon_lec"] ?></a></th>
                        <th class="py-3 text-center"><a href="<?= '?' . $sorting["parameter_lab"] ?>" target="_top" style="text-decoration: none; color: #000;">ภาคปฏิบัติ<?= $sorting["icon_lab"] ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $sql = "SELECT * FROM `teaching_load` WHERE `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
                    $sql = "SELECT * FROM `teaching_load` where teaching_load_semester = " . $semester . " AND teaching_load_edu_year = '" . $edu_year . "'";
                    if ($_GET["p"] == 'teacherreport') {
                        $sql .= " AND teaching_load_department <> 'อาจารย์พิเศษ'";
                    } else if ($_GET["p"] == 'externalreport') {
                        $sql .= " AND teaching_load_department == 'อาจารย์พิเศษ'";
                    }
                    $work_hour = $fnc->get_db_array($sql . $sorting["sortby"]);
                    if (!empty($work_hour)) {
                        $i = 1;
                        foreach ($work_hour as $wh) {
                    ?>
                            <tr class="tr_contents">
                                <td scope="row" class="text-center"><?= $i; ?></td>
                                <td><a href="../admin/index.php?p=userview&cap_uid=<?= $wh["teaching_load_citizenid"]; ?>&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>" target="_blank"><?= $fnc->gen_titlePosition_short($wh["teaching_load_titlePosition"]) . $wh["teaching_load_firstName"] . '&nbsp;&nbsp;' . $wh["teaching_load_lastName"]; ?></a></td>
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

    function curriculum_report($semester, $edu_year, $cid = NULL)
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;
        // echo $semester . ' / ' . $edu_year;

        $course_title = "";
        if (isset($_GET['p'])) {
            switch ($_GET['p']) {
                case "curriculumReportAR":
                    $course_view = "สถาปัตยกรรมศาสตร์";
                    break;
                case "curriculumReportLA":
                    $course_view = "ภูมิสถาปัตยกรรมศาสตร์";
                    break;
                case "curriculumReportLT":
                    $course_view = "เทคโนโลยีภูมิทัศน์";
                    break;
                case "curriculumReportMURP":
                    $course_view = "การวางผังเมืองและสภาพแวดล้อม";
                    break;
                case "curriculumReportAV":
                    $course_view = "การออกแบบและวางแผนสิ่งแวดล้อม";
                    break;
                default:
                    $course_view = "";
            }
            if ($course_view) {
                $course_title = "<br>หลักสูตร" . $course_view;
                $course_view = " AND teaching_load_department LIKE '" . $course_view . "'";
            }
        }

        // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
        // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
        // $fnc->debug_console("teacher list : ", $teacher_list);
        // foreach ($teacher_list as $teacher) {
        //     $sql = "SELECT count(`teaching_load_citizenid`) as cnt_id FROM `teaching_load` WHERE `teaching_load_citizenid` = '" . $teacher["citizenId"] . "' AND `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
        //     if (empty($fnc->get_db_col($sql))) {
        //         $sql_insert = "INSERT INTO `teaching_load` (`teaching_load_citizenid`, `teaching_load_titlePosition`, `teaching_load_firstName`, `teaching_load_lastName`, `teaching_load_semester`, `teaching_load_edu_year`, `teaching_load_lastupdate`) 
        //             VALUES ('" . $teacher["citizenId"] . "', '" . $teacher["titlePosition"] . "', '" . $teacher["firstName"] . "', '" . $teacher["lastName"] . "', " . $semester . ", '" . $edu_year . "', current_timestamp())";
        //         $fnc->sql_execute($sql_insert);
        //     }
        // }


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

        // $sql = "SELECT teaching_load_edu_year AS edu_year, teaching_load_semester AS semester FROM teaching_load WHERE teaching_load_department Is Not Null GROUP BY teaching_load_edu_year, teaching_load_semester ORDER BY teaching_load_edu_year DESC , teaching_load_semester DESC LIMIT 1";
        // $sql = "SELECT cap_semester AS semester, cap_year AS edu_year FROM v_cap2 GROUP BY cap_semester, cap_year ORDER BY cap_year DESC , cap_semester DESC LIMIT 1";
        // $this->debug_console("last: " . $sql);
        // $last = $fnc->get_db_row($sql);
        // $sql = "SELECT teaching_load_department AS department FROM teaching_load WHERE teaching_load_edu_year = '" . $last["edu_year"] . "' AND teaching_load_semester = '" . $last["semester"] . "' GROUP BY teaching_load_department ORDER BY teaching_load_department";
        // $sql = "SELECT * FROM `v_cap2` WHERE cap_semester = 2 And cap_year = '" . $last["edu_year"] . "' AND teaching_load_department != '' GROUP BY teaching_load_department ORDER BY teaching_load_department, course_code_th";
        // $this->debug_console("department sql : " . $sql);
        // $department = $fnc->get_db_array($sql);
        // $this->debug_console("department data : " . $department);
        // if (!empty($department)) {
        // foreach ($department as $dept) {
        // $sql = "SELECT * FROM teaching_load WHERE teaching_load_edu_year = '" . $_GET["edu_year"] . "' AND teaching_load_semester = '" . $_GET["semester"] . "'" . $course_view . " ORDER BY teaching_load_firstName";
        // $this->debug_console("teacher1356 : " . $sql);
        // $teacher = $fnc->get_db_array($sql);
        // if (!empty($teacher)) {
        //     foreach ($teacher as $row) {
        //         echo '<p>data</p>';
        //     }
        // }
        // }
        // }

        $sorting = array(
            'sortby' => '', 'parameter' => '',
            'parameter_teacher' => '', 'icon_teacher' => '',
            'parameter_lec' => '', 'icon_lec' => '',
            'parameter_lab' => '', 'icon_lab' => '',
            'icon_a' => '<i class="bi bi-sort-alpha-down fw-bold ms-2" style="font-size: 1.2em;"></i>', 'icon_z' => '<i class="bi bi-sort-alpha-down-alt fw-bold ms-2" style="font-size: 1.2em;"></i>'
        );
        $sorting = $fnc->table_teaching_load_sorting($sorting);
        $fnc->debug_console("sorting: ", $sorting);

    ?>
        <div class="container border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-9 align-self-end">
                    <p class="text-warning h4">สรุปภาระงานสอนคณาจารย์ (<?= $semester ?>/<?= $edu_year ?>)<?= $course_title ?></p>
                </div>
                <div class="col-md-3" style="font-size: 0.8em;">
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

            <table class="table table-striped table-bordered table-hover responsive table-light" style="font-size: 1.2em">
                <thead class="thead-inverse">
                    <tr class="table-secondary">
                        <th class="text-center py-3">#</th>
                        <th class="py-3"><a href="<?= '?' . $sorting["parameter_teacher"] ?>" target="_top" style="text-decoration: none; color: #000;">อาจารย์<?= $sorting["icon_teacher"] ?></a></th>
                        <th class="py-3 text-center"><a href="<?= '?' . $sorting["parameter_lec"] ?>" target="_top" style="text-decoration: none; color: #000;">ภาคบรรยาย<?= $sorting["icon_lec"] ?></a></th>
                        <th class="py-3 text-center"><a href="<?= '?' . $sorting["parameter_lab"] ?>" target="_top" style="text-decoration: none; color: #000;">ภาคปฏิบัติ<?= $sorting["icon_lab"] ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `teaching_load` WHERE `teaching_load_semester` = " . $semester . " AND `teaching_load_edu_year` = '" . $edu_year . "'";
                    if ($course_view) {
                        $sql .= $course_view;
                    }
                    $this->debug_console("teaching load sql : " . $sql);
                    $work_hour = $fnc->get_db_array($sql . $sorting["sortby"]);
                    if (!empty($work_hour)) {
                        $i = 1;
                        foreach ($work_hour as $wh) {
                    ?>
                            <tr class="tr_contents">
                                <td scope="row" class="text-center"><?= $i; ?></td>
                                <td><a href="../admin/index.php?p=userview&cap_uid=<?= $wh["teaching_load_citizenid"]; ?>&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>" target="_blank"><?= $fnc->gen_titlePosition_short($wh["teaching_load_titlePosition"]) . $wh["teaching_load_firstName"] . '&nbsp;&nbsp;' . $wh["teaching_load_lastName"]; ?></a></td>
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

    function external_report($semester, $edu_year, $cid = NULL)
    {
        $fnc = $this;
        $sql = "SELECT teacher_ext_citizenid as citizenId, teacher_ext_titleName as titleName, teacher_ext_titlePosition as titlePosition, teacher_ext_firstName as firstName, teacher_ext_lastName as lastName, SUM(cas_lecture_hours) AS sum_cas_lec_hours, SUM(cas_lab_hours) AS sum_cas_lab_hours, cap_semester, cap_year 
        FROM teacher_ext RIGHT JOIN course_active_secondary ON cas_citizenid = teacher_ext_citizenid INNER JOIN course_active_primary ON course_active_primary.cap_id = course_active_secondary.cap_id 
        WHERE teacher_ext_status = 'enable' AND cap_semester = " . $semester . " AND cap_year = '" . $edu_year . "' 
        GROUP BY teacher_ext_citizenid, teacher_ext_titleName, teacher_ext_titlePosition, teacher_ext_firstName, teacher_ext_lastName ORDER BY teacher_ext_firstName";
        $teacher_list = $fnc->get_db_array($sql);
        // $fnc->debug_console("teacher list : ", $teacher_list); 
    ?>
        <div class="container border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-9 align-self-end">
                    <p class="text-warning h4">สรุปภาระงานสอนอาจารย์พิเศษ (<?= $semester ?>/<?= $edu_year ?>)</p>
                </div>
                <div class="col-md-3" style="font-size: 0.8em;">
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

            <table class="table table-striped table-bordered table-hover responsive table-light">
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
                    if (!empty($teacher_list)) {
                        $i = 1;
                        foreach ($teacher_list as $wh) {
                    ?>
                            <tr class="tr_contents">
                                <td scope="row" class="text-center"><?= $i; ?></td>
                                <td><a href="../admin/index.php?p=userview&cap_uid=<?= $wh["citizenId"]; ?>&semester=<?= $semester ?>&edu_year=<?= $edu_year ?>"><?= $fnc->gen_titlePosition_short($wh["titlePosition"]) . $wh["firstName"] . '&nbsp;&nbsp;' . $wh["lastName"]; ?></a></td>
                                <td class="text-center"><?= $wh["sum_cas_lec_hours"] ?></td>
                                <td class="text-center"><?= $wh["sum_cas_lab_hours"] ?></td>
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

    public function get_newest_semester_edu_year($uid)
    {
        // * step 1
        $sql = "Select coap.cap_semester As semester, coap.cap_year As edu_year From course_active_secondary coas Left Join course_active_primary coap On coap.cap_id = coas.cap_id Where coas.cas_citizenid = '" . $uid . "' Order By edu_year Desc, semester Desc Limit 1";
        $this->debug_console("edu year newest: " . $sql);
        $newest = $this->get_db_row($sql);
        if (!empty($newest)) {
            $_SESSION["admin"]["edu_year"] = $newest['edu_year'];
            $_SESSION["admin"]["semester"] = $newest['semester'];
        }
        // * step 2
        $sql = "Select coap.cap_semester as semester, coap.cap_year as edu_year From course_active_primary coap Where coap.cap_citizenid = '" . $uid . "' Order By coap.cap_year Desc, coap.cap_semester Desc Limit 1";
        $this->debug_console("edu year newest2: " . $sql);
        $newest = $this->get_db_row($sql);
        if (!empty($newest)) {
            // if ($newest['edu_year'] > $_SESSION["admin"]["edu_year"]) {
            $_SESSION["admin"]["edu_year"] = $newest['edu_year'];
            $_SESSION["admin"]["semester"] = $newest['semester'];
            // }
        }
        if (empty($_SESSION["admin"]["edu_year"])) {
            $_SESSION["admin"]["edu_year"] = (date("Y") + 543);
            $_SESSION["admin"]["semester"] = 1;
        }
    }

    // * display table cap
    public function view_user($uid, $semester, $edu_year)
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person = $this->api_person;

        $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $uid . "'";
        $cap_info = $fnc->get_db_row($sql);
        if (empty($cap_info)) {
            // ! if not found whhat happen - show nothing
            // die("not found.");
            // echo ("not found.");
        }
        $fnc->debug_console("cap_info filter sql: ", $cap_info);
        // $user_info = $MJU_API->GetAPI_array($api_person . $uid)[0];
        $user_info = $fnc->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $uid . "'");
        $fnc->debug_console("user_info: ", $user_info);
        $page_title = 'ภาระงานสอนอาจารย์';

        if (!$user_info) {
            $user_info = $fnc->get_db_row("SELECT teacher_ext_titlePosition as titlePosition, teacher_ext_firstName as firstName, teacher_ext_lastName as lastName FROM `teacher_ext` WHERE `teacher_ext_citizenId` = '" . $uid . "'");
            $fnc->debug_console("user_info: ", $user_info);
            $page_title = 'ภาระงานสอนอาจารย์พิเศษ';
        }

        if (isset($semester)) {
            $cap_info["cap_semester"] = $semester;
        }
        if (isset($edu_year)) {
            $cap_info["cap_year"] = $edu_year;
        }

        $hrs_lec_sum = 0;
        $hrs_lab_sum = 0;

    ?>
        <div class="container border-bottom mb-4">
            <form action="?" method="get" class="mt-4">
                <input type="hidden" name="p" value="<?= $_GET["p"]; ?>">
                <div class="page_header_teacher bg-gradient">
                    <h5><?= $page_title ?></h5>
                </div>
                <div class="row mt-2 mb-3">
                    <div class="col-6 col-md-8 mt-2">
                        <p class="title h5 text-warning"><?= $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></p>
                        <p class="title h6 d-none">ภาคการศึกษา <?= $cap_info["cap_semester"] . "/" . $cap_info["cap_year"]; ?></p>
                        <p class="title h6">ภาคบรรยาย <label id="user_lec_hrs" class="text-info">0</label> ชม. , ภาคปฏิบัติ <label id="user_lab_hrs" class="text-info">0</label> ชม. ในภาคการศึกษา <?= $cap_info["cap_semester"] . "/" . $cap_info["cap_year"]; ?></p>
                    </div>

                    <div class="col-6 col-md-4 align-self-end d-print-none">
                        <div class="row row-cols-2 gx-2">
                            <div class="col form-group">
                                <label for="semester" class="form-label">ภาคการศึกษา</label>
                                <select id="semester" name="semester" class="form-select form-select-sm" aria-label="Default select example" onchange="this.form.submit()">
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
                            <div class="col form-group">
                                <label for="semester" class="form-label">ปีการศึกษา</label>
                                <select id="edu_year" name="edu_year" class="form-select form-select-sm" aria-label="Default select example" onchange="this.form.submit()">
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
                <input type="hidden" name="cap_uid" value="<?= $uid; ?>">
            </form>

            <div class="table mb-3">
                <table class="table table-bordered mt-4 table-light" style="font-size: 1.4em">
                    <!-- table table-striped table-bordered table-hover table-responsive"> -->
                    <?php
                    $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $uid . "' AND cap_semester = " . $semester . " AND cap_year = '" . $edu_year . "' ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc, cap_notes Asc";
                    $cap_list = $fnc->get_dataset_array($sql);
                    $fnc->debug_console("cap_list sql: " . $sql);
                    ?>
                    <thead class="thead-inverse">
                        <tr class="">
                            <th class="text-center h5" colspan="3" style="background-color: #cae4f4;">เป็นเจ้าของวิชา</th>
                        </tr>
                        <tr class="" style="font-size: 0.8em">
                            <th class="text-center align-items-center">รหัส - ชื่อวิชา</th>
                            <th class="text-center">ภาคบรรยาย (ชม.)</th>
                            <th class="text-center">ภาคปฏิบัติ (ชม.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($cap_list)) {
                            foreach ($cap_list as $cap) {
                        ?>
                                <tr class="tr_contents">
                                    <td scope="row"><a href="?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>" target="_blank"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                            <?php if (!empty($cap["course_credit"])) {
                                                // echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                                            } ?>
                                        </a></td>
                                    <?php
                                    // $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                    $user_info = $fnc->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'");
                                    ?>
                                    <!-- <td class="text-center"><a href="?p=userview&cap_uid=<? //= $cap["cap_citizenid"] . '">' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; 
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
                        Where coas.cas_citizenid LIKE '" . $uid . "' And coas.cas_status = 'enable' And coap.cap_status = 'enable' And coap.cap_semester = " . $cap_info["cap_semester"] . " And coap.cap_year = '" . $cap_info["cap_year"] . "' Order By coap.cap_year, coap.cap_semester, cou.course_code_th, coap.cap_notes";
                        // $fnc->debug_console("cap_list ta sql: " . $sql);
                        $cap_list = $fnc->get_dataset_array($sql);
                        ?>
                        <tr class="">
                            <td class="text-center py-3" colspan="3" style="background-color: #333"></td>
                        </tr>
                        <thead class="thead-inverse mt-2">
                            <tr class="">
                                <th class="text-center h5" colspan="3" style="background-color: #cef0d0;">เป็นผู้สอนร่วม</th>
                            </tr>
                            <tr class="" style="font-size: 0.8em">
                                <th class="text-center align-items-center">รหัส - ชื่อวิชา</th>
                                <th class="text-center">ภาคบรรยาย (ชม.)</th>
                                <th class="text-center">ภาคปฏิบัติ (ชม.)</th>
                            </tr>
                        </thead>
                        <?php
                        if (!empty($cap_list)) {
                            foreach ($cap_list as $cap) {
                        ?>
                                <tr class="tr_contents">
                                    <td scope="row"><a href="?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                            <?php if (!empty($cap["course_credit"])) {
                                                // echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
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

            <?php if ($_SESSION["admin"]["auth_lv"] >= 7) { ?>
                <div class="text-end mt-5 mb-3 d-print-none">
                    <a href="?" target="_top" class="btn btn-secondary text-uppercase px-5" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกและกลับ"><i class="bi <?= $this->icon["close"] ?> me-2"></i>close</a>
                </div>
            <?php } ?>

        </div>
    <?php
    }

    // * display table cap
    function view_user2()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person = $this->api_person;

        $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $_GET["cap_uid"] . "'";
        $cap_info = $fnc->get_db_row($sql);
        if (empty($cap_info)) {
            // ! if not found whhat happen - show nothing
            // die("not found.");
            // echo ("not found.");
        }
        $fnc->debug_console("cap_info filter sql: ", $cap_info);
        // $user_info = $MJU_API->GetAPI_array($api_person . $_GET["cap_uid"])[0];
        $user_info = $fnc->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $_GET["cap_uid"] . "'");
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
                <input type="hidden" name="p" value="<?= $_GET["p"]; ?>">
                <div class="page_header">
                    <h2 class="h2">ภาระงานสอนอาจารย์</h2>
                </div>
                <div class="row">
                    <div class="col-4 col-md-7">
                        <p class="title h3 text-primary"><?= $user_info["titlePosition"] . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></p>
                        <p class="title h4">ภาคการศึกษา <?= $cap_info["cap_semester"] . "/" . $cap_info["cap_year"]; ?></p>
                        <p class="title h4">ภาคบรรยาย <label id="user_lec_hrs">0</label> ชม. , ภาคปฏิบัติ <label id="user_lab_hrs">0</label> ชม.</p>
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
                    $sql = "SELECT * FROM v_cap WHERE cap_citizenid LIKE '" . $_GET["cap_uid"] . "' AND cap_semester = " . $_GET["semester"] . " AND cap_year = '" . $_GET["edu_year"] . "' ORDER BY cap_year Desc, cap_semester Desc, course_code_th Asc, cap_notes Asc";
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
                                    <td scope="row"><a href="?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
                                            <?php if (!empty($cap["course_credit"])) {
                                                echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                                            } ?>
                                        </a></td>
                                    <?php
                                    // $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                    $user_info = $fnc->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'");
                                    ?>
                                    <!-- <td class="text-center"><a href="?p=userview&cap_uid=<? //= $cap["cap_citizenid"] . '">' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; 
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
                        Where coas.cas_citizenid LIKE '" . $_GET["cap_uid"] . "' And coas.cas_status = 'enable' And coap.cap_status = 'enable' And coap.cap_semester = " . $cap_info["cap_semester"] . " And coap.cap_year = '" . $cap_info["cap_year"] . "' Order By coap.cap_year, coap.cap_semester, cou.course_code_th, coap.cap_notes";
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
                                    <td scope="row"><a href="?p=courseview&cap_cid=<?= $cap["course_id"]; ?>&cap_id=<?= $cap["cap_id"]; ?>"><?= $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"] ?>
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
                <a href="?" target="_top" class="btn btn-secondary text-uppercase px-5" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกและกลับ"><i class="bi <?= $this->icon["close"] ?> me-2"></i>close</a>
            </div>

        </div>
    <?php
    }

    public function table_course_sorting($sorting)
    {
        $fnc = $this;
        $page_parameter = $fnc->get_url_parameter();

        if (stripos($page_parameter, "&page=")) {
            $page_parameter = explode("&", $page_parameter);
            array_pop($page_parameter);
            $page_parameter = implode("&", $page_parameter);
        }
        $sorting["parameter"] = $page_parameter;
        if (stripos($page_parameter, "&sortby=")) {
            $page_parameter = explode("&", $page_parameter);
            array_pop($page_parameter);
            $page_parameter = implode("&", $page_parameter);
        }

        if (!isset($_GET['sortby'])) {
            $sorting["icon_course"] = $sorting["icon_a"];
            $sorting["sortby"] = " order by course_name_th, cap_notes";
            $sorting["parameter_course"] = $page_parameter . '&sortby=' . 'Acourse';
            $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ateacher';
        } else {
            switch ($_GET['sortby']) {
                case "Acourse":
                    $sorting["icon_course"] = $sorting["icon_a"];
                    $sorting["sortby"] = ' order by course_name_th, cap_notes';;
                    $sorting["parameter_course"] = $page_parameter . '&sortby=' . 'Zcourse';
                    $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ateacher';
                    break;
                case "Zcourse":
                    $sorting["icon_course"] = $sorting["icon_z"];
                    $sorting["sortby"] = ' order by course_name_th Desc, cap_notes';;
                    $sorting["parameter_course"] = $page_parameter . '&sortby=' . 'Acourse';
                    $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ateacher';
                    break;
                case "Ateacher":
                    $sorting["icon_teacher"] = $sorting["icon_a"];
                    $sorting["sortby"] = ' order by teaching_load_firstName, cap_notes';;
                    $sorting["parameter_course"] = $page_parameter . '&sortby=' . 'Acourse';
                    $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Zteacher';
                    break;
                case "Zteacher":
                    $sorting["icon_teacher"] = $sorting["icon_z"];
                    $sorting["sortby"] = ' order by teaching_load_firstName Desc, cap_notes';;
                    $sorting["parameter_course"] = $page_parameter . '&sortby=' . 'Acourse';
                    $sorting["parameter_teacher"] = $page_parameter . '&sortby=' . 'Ateacher';
                    break;
            }
        }
        return $sorting;
    }

    // * display table cap
    public function cap_table($semester, $edu_year)
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person = $this->api_person;

        $course_view = "";
        $course_title = "";
        if (isset($_GET['p'])) {
            switch ($_GET['p']) {
                case "CourseReportAR":
                    $course_view = "สถาปัตยกรรมศาสตร์";
                    break;
                case "CourseReportLA":
                    $course_view = "ภูมิสถาปัตยกรรมศาสตร์";
                    break;
                case "CourseReportLT":
                    $course_view = "เทคโนโลยีภูมิทัศน์";
                    break;
                case "CourseReportMURP":
                    $course_view = "การวางผังเมืองและสภาพแวดล้อม";
                    break;
                case "CourseReportAV":
                    $course_view = "การออกแบบและวางแผนสิ่งแวดล้อม";
                    break;
                default:
                    $course_view = "";
            }
            if ($course_view) {
                $course_title = "<br>หลักสูตร" . $course_view;
                $course_view = " AND cap_department LIKE '" . $course_view . "'";
            }
        }

        $sql_page = "SELECT count(*), (course_lec * course_lec_hrs) - cap_lecture_hours AS lec_hrs_left, (course_lab * course_lab_hrs) - cap_lab_hours AS lab_hrs_left FROM v_cap2";
        $sql_page = "SELECT *, (course_lec * course_lec_hrs) - cap_lecture_hours AS lec_hrs_left, (course_lab * course_lab_hrs) - cap_lab_hours AS lab_hrs_left FROM v_cap2";
        $sql = "SELECT *, (course_lec * course_lec_hrs) - cap_lecture_hours AS lec_hrs_left, (course_lab * course_lab_hrs) - cap_lab_hours AS lab_hrs_left FROM v_cap2";
        $sorting = array(
            'sortby' => '', 'parameter' => '', 'parameter_course' => '', 'icon_course' => '', 'sortby_teacher' => 'Ateacher', 'parameter_teacher' => '', 'icon_teacher' => '',
            'icon_a' => '<i class="bi bi-sort-alpha-down fw-bold ms-2" style="font-size: 1.2em;"></i>', 'icon_z' => '<i class="bi bi-sort-alpha-down-alt fw-bold ms-2" style="font-size: 1.2em;"></i>'
        );
        $sorting = $fnc->table_course_sorting($sorting);
        $fnc->debug_console("sorting: ", $sorting);

        $sql_key = "";
        if (isset($_GET["k"])) {
            $key = explode(" ", $_GET["k"]);
            foreach ($key as $k) {
                $sql_key = " AND (course_code_th LIKE '%" . $k . "%' OR course_name_th LIKE '%" . $k . "%')";
            }
            // $sql .= " AND (course_code_th LIKE '%" . $_GET["k"] . "%' OR course_name_th LIKE '%" . $_GET["k"] . "%')";
        }

        if (isset($semester) && isset($edu_year)) {
            $sql_where = " WHERE cap_semester = " . $semester . " AND cap_year = '" . $edu_year . "'" . $sql_key;
        } else {
            $sql_where = " WHERE cap_id <> ''" . $sql_key;
        }
        $sql_where .= " AND v_cap2.teaching_load_department <> ''";
        $sql_group = " group by cap_citizenid";
        // $sql_page .= $sql_where . $course_view;
        $sql .= $sql_where . $course_view . $sql_group . $sorting["sortby"];

        // * Current pagination page number
        $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
        // * Calculate total pages
        $list_allRecords = count($fnc->get_db_array($sql));
        $fnc->debug_console("list_allRecords: " . $sql);
        $totoalPages = ceil($list_allRecords / $fnc->list_limit);
        $fnc->debug_console("totoalPages: " . ceil($list_allRecords / $fnc->list_limit) . "\\n" . "ceil " . $list_allRecords);
        // * Prev + Next
        $prev = $page - 1;
        $next = $page + 1;
        // * Offset
        // $paginationStart = ($page - 1) * $fnc->list_limit;
        $paginationStart = (($page - 1) * $fnc->list_limit) ;

        // $sql = "SELECT *, (course_lec * course_lec_hrs) - cap_lecture_hours AS lec_hrs_left, (course_lab * course_lab_hrs) - cap_lab_hours AS lab_hrs_left FROM v_cap2" . $sql;
        // $sql .= $course_view . $sql_group . $sorting["sortby"];
        // $sql .= " Limit $paginationStart, $fnc->list_limit";
        // $sql .= $sql_where . $course_view . $sql_group . $sorting["sortby"];
        $sql .= " Limit $paginationStart, $fnc->list_limit";
        $cap_list = $fnc->get_db_array($sql);
        $fnc->debug_console("cap list sql:", $sql);
        // $fnc->debug_console("cap list:", $cap_list);
    ?>
        <div class="container border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 align-self-end">
                    <h5 class="text-light mb-0">วิชาที่ลงทะเบียนแล้ว
                        <?PHP
                        if (!empty($cap_list)) {
                            echo ' (' . count($cap_list) . ' รายวิชา)';
                        }
                        echo $course_title;
                        ?></h5>
                    <?php
                    if (isset($_GET["k"])) {
                    ?>
                        <p class="mb-1 text-info fw-light">ค้นหา: <?= implode(", ", $key) ?>
                            <span class="ms-2">
                                <a href="?<?= 'p=' . $_GET["p"] . '&semester=' . $_GET["semester"] . '&edu_year=' . $_GET["edu_year"] ?>" target="_top" class="link-warning" data-bs-toggle="tooltip" data-bs-placement="right" title="ยกเลิกการค้นหา"><i class="bi bi-x-circle"></i></a>
                            </span>
                        </p>
                    <?php } ?>
                </div>
                <div class="col-md-5" style="font-size: 0.8em;">
                    <form action="?" method="get" class="mt-4">
                        <input type="hidden" name="p" value="<?= $_GET["p"] ?>">
                        <div class="row gx-2">
                            <div class="col-3 form-group">
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
                            <div class="col-3 form-group">
                                <label for="edu_year" class="form-label">ปีการศึกษา</label>
                                <select id="edu_year" name="edu_year" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php
                                    for ($i = date("Y") + 543; $i >= 2563; $i--) {
                                        echo '<option value="' . $i . '"';
                                        if (isset($edu_year) && $edu_year == $i) {
                                            echo " selected";
                                        }
                                        echo '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 form-group">
                                <label for="edu_year" class="form-label">ค้นหาวิชา</label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="text" name="k" class="form-control" placeholder="รหัส/ชื่อ วิชา" <?php if (isset($_GET["k"])) {
                                                                                                                        echo 'value="' . $_GET["k"] . '"';
                                                                                                                    } ?>>
                                    <button class="btn btn-success" type="submit" id="button-addon2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ค้นหา"><i class="bi <?= $this->icon["search"] ?>"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped table-bordered table-hover table-light mb-0">
                <thead class="thead-inverse">
                    <tr class="table-secondary">
                        <th class="text-center py-3">#</th>
                        <th class="text-center py-3 d-none d-md-table-cell">ภาคการศึกษา</th>
                        <th class="py-3"><a href="<?= '?' . $sorting["parameter_course"] ?>" target="_top" style="text-decoration: none; color: #000;">ชื่อวิชา<?= $sorting["icon_course"] ?></a></th>
                        <th class="py-3" colspan="2"><a href="<?= '?' . $sorting["parameter_teacher"] ?>" target="_top" style="text-decoration: none; color: #000;">เจ้าของวิชา<?= $sorting["icon_teacher"] ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($cap_list)) {
                        $i = (1 * $paginationStart) + 1;
                        foreach ($cap_list as $cap) {
                            echo '<tr class="tr_contents">';
                            echo '<td scope="row" class="text-center" style="vertical-align: middle;">' . $i . '</td>';
                            echo '<td scope="row" class="text-center d-none d-md-table-cell" style="vertical-align: middle;">' . $cap["cap_semester"] . '/' . $cap["cap_year"] . '</td>';
                            echo '<td style="vertical-align: middle;"><a href="?p=courseview&cap_cid=' . $cap["course_id"] . '&cap_id=' . $cap["cap_id"] . '" target="_blank">' . $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"];
                            echo '</a>';
                            if (!empty($cap["course_credit"])) {
                                echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                            }
                            $hrs_icon = '<i class="bi bi-check2-circle text-success fs-5 fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" title="กำหนด ชม. สอนครบแล้ว"></i>';
                            if ($cap["lec_hrs_left"] != 0 || $cap["lab_hrs_left"] != 0) {
                                $sql = "SELECT SUM(coas.cas_lecture_hours) AS Sum_cas_lecture_hours, SUM(coas.cas_lab_hours) AS Sum_cas_lab_hours FROM course_active_secondary coas WHERE coas.cap_id = " . $cap["cap_id"] . " AND coas.cas_status = 'enable'";
                                $secondary_hrs = $fnc->get_db_row($sql);
                                $cap["lec_hrs_left"] = $cap["lec_hrs_left"] - $secondary_hrs["Sum_cas_lecture_hours"];
                                $cap["lab_hrs_left"] = $cap["lab_hrs_left"] - $secondary_hrs["Sum_cas_lab_hours"];
                                if ($cap["lec_hrs_left"] != 0 || $cap["lab_hrs_left"] != 0) {
                                    $hrs_icon = '<i class="bi bi-exclamation-triangle text-warning fs-6 fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" title="ยังคงเหลือ ชม. สอน"></i>';
                                } else {
                                    $hrs_icon = '<i class="bi bi-check2-circle text-success fs-5 fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" title="กำหนด ชม. สอนครบแล้ว"></i>';
                                }
                            // } else {
                                // $hrs_icon = '<i class="bi bi-check2-circle text-success fs-5 fw-bold" data-bs-toggle="tooltip" data-bs-placement="right" title="กำหนด ชม. สอนครบแล้ว"></i>';
                            }
                            echo '<span class="text-end ms-3">' . $hrs_icon;
                            // echo ' : ' . $cap["lec_hrs_left"] . ',' . $cap["lab_hrs_left"];
                            echo '</span>';
                            echo '</td>';
                            // $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                            // if ($cap["cap_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 5) {
                            // show user link for board officer developer
                            if ($_SESSION["admin"]["auth_lv"] >= 5) {
                                echo '<td style="vertical-align: middle;"><a href="?p=userview&cap_uid=' . $cap["cap_citizenid"] . '&semester=' . $cap["cap_semester"] . '&edu_year=' . $cap["cap_year"] . '">' . $this->gen_titlePosition_short($cap["teaching_load_titlePosition"]) . $cap["teaching_load_firstName"] . '&nbsp;&nbsp;' . $cap["teaching_load_lastName"] . '</a></td>';
                            } else {
                                echo '<td style="vertical-align: middle;">' . $cap["teaching_load_firstName"] . '&nbsp;&nbsp;' . $cap["teaching_load_lastName"] . '</td>';
                            }

                            if (isset($_SESSION["admin"]) && $_SESSION["admin"]["auth_lv"] >= 7) {
                                echo '<td class="text-end" style="vertical-align: middle;">';
                                if ($_SESSION["admin"]["editable"] == "true") {
                                    echo '<a href="index.php?p=capedit&cap_id=' . $cap["cap_id"] . '" target="_top" class="btn btn-sm btn-warning btn-sm text-uppercase w-100" style="font-size: 0.8em;"><i class="bi ' . $this->icon["edit"] . ' me-1"></i>แก้ไขข้อมูล</a>';
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
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

            <?php if ($totoalPages > 1) {
                $nav_link = $sorting["parameter"];
            ?>
                <!-- pagination -->
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($page <= 1) {
                                                    echo 'disabled';
                                                } ?>">
                            <a class="page-link" href="<?php if ($page <= 1) {
                                                            echo '#';
                                                        } else {
                                                            echo "?" . $nav_link . "&page=" . $prev;
                                                        } ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totoalPages; $i++) : ?>
                            <li class="page-item <?php if ($page == $i) {
                                                        echo 'active';
                                                    } ?>">
                                <a class="page-link" href="?<?= $nav_link ?>&page=<?= $i; ?>"> <?= $i; ?> </a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($page >= $totoalPages) {
                                                    echo 'disabled';
                                                } ?>">
                            <a class="page-link" href="<?php if ($page >= $totoalPages) {
                                                            echo '#';
                                                        } else {
                                                            echo "?" . $nav_link . "&page=" . $next;
                                                        } ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php } ?>
        </div>
    <?php
    }

    // * display table cap
    public function cap_table2()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person = $this->api_person;
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
                        $sql = "SELECT * FROM v_cap order by cap_year Desc, cap_semester Desc, course_code_th ASC";
                    }
                    $cap_list = $fnc->get_db_array($sql);
                    $fnc->debug_console("cap list sql:", $sql);
                    $fnc->debug_console("cap list:", $cap_list);
                    if (!empty($cap_list)) {
                        foreach ($cap_list as $cap) {
                            echo '<tr>';
                            echo '<td scope="row" class="text-center">' . $cap["cap_semester"] . '/' . $cap["cap_year"] . '</td>';
                            echo '<td><a href="?p=courseview&cap_cid=' . $cap["course_id"] . '&cap_id=' . $cap["cap_id"] . '">' . $cap["course_code_th"] . ' ' . $cap["course_name_th"] . ' ' . $cap["cap_notes"];
                            if (!empty($cap["course_credit"])) {
                                echo ' : ' . $cap["course_credit"] . ' นก. (' . $cap["course_lec"] . '-' . $cap["course_lab"] . '-' . $cap["course_self"] . ')';
                            }
                            echo '</a></td>';
                            // $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];                            
                            // $user_info = "SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'";
                            $user_info = $this->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'");
                            if ($cap["cap_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 5) {
                                echo '<td><a href="?p=userview&cap_uid=' . $cap["cap_citizenid"] . '&semester=' . $cap["cap_semester"] . '&edu_year=' . $cap["cap_year"] . '">' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"] . '</a></td>';
                            } else {
                                echo '<td>' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"] . '</td>';
                            }

                            if (isset($_SESSION["admin"]) && $_SESSION["admin"]["auth_lv"] >= 7) {
                                echo '<td class="text-end"><a href="index.php?p=capedit&cap_id=' . $cap["cap_id"] . '" target="_top" class="btn btn-warning btn-sm text-uppercase w-100">แก้ไขข้อมูล</a></td>';
                            }
                            echo '</tr>';
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

    // * display table cap
    public function view_course_primary()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person = $this->api_person;

        $sql = "SELECT * FROM v_cap2 WHERE cap_id = " . $_GET["cap_id"];
        $fnc->debug_console("view course primary sql: ", $sql);
        $cap_info = $fnc->get_db_array($sql)[0];
        $fnc->debug_console("cap_info filter: ", $cap_info);
        // $user_info = $MJU_API->GetAPI_array($api_person . $cap_info["cap_citizenid"])[0];
        // $user_info = "SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap_info["cap_citizenid"] . "'";
        $user_info = $this->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap_info["cap_citizenid"] . "'");

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
                <div class="page_header_course bg-gradient">
                    <h5>รายละเอียดวิชาที่เปิดสอน</h5>
                </div>
                <div class="row">
                    <div class="col-6 col-md-8 mb-3">
                        <!-- <h2 class="" style="color: lightgreen;">Course View2</h2> -->
                        <h5 class="title text-warning"><?= $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . ' ' . $cap_info["cap_notes"]; ?></h5>
                        <h6><?= $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lec"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ')'; ?>
                            <?php
                            if (!empty($_SESSION["admin"]) && $_SESSION["admin"]["auth_lv"] >= 7 && $_SESSION["admin"]["editable"] == 'true') {
                                echo '<a href="course.php?p=courseedit&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '" class="btn btn-sm btn-warning ms-2" style="font-size: 0.8em;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="แก้ไขรายละเอียของรายวิชา"><i class="bi ' . $this->icon["edit"] . ' me-2"></i>แก้ไขหน่วยกิต</a>';
                            }
                            ?></h6>
                    </div>
                    <div class="col align-self-end mb-2" style="font-size: 0.8em;">
                        <div class="row gx-2">
                            <div class="col-6 form-group">
                                <label for="semester" class="form-label">ภาคการศึกษา</label>
                                <select id="semester" name="semester" class="form-select form-select-sm" onchange="this.form.submit()">
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
                                <select id="edu_year" name="edu_year" class="form-select form-select-sm" onchange="this.form.submit()">
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
                <table class="table table-bordered table-light mt-4">
                    <!-- table table-striped table-bordered table-hover table-responsive"> -->
                    <thead class="thead-inverse">
                        <tr class="">
                            <th>ผู้สอน</th>
                            <th>ภาระงานสอน (ชม.ต่อภาคการศึกษา)<p class="p-0 m-0 text-warning fw-light" style="font-size: 0.75em;"><?php if ($cap_info["course_studio"] != "true") {
                                                                                                                                        $hrs = $this->get_hrs($_GET["cap_id"], $cap_info["course_id"]);
                                                                                                                                    } elseif ($cap_info["course_name_th"] == "สหกิจศึกษา") {
                                                                                                                                        echo " * วิชาสหกิจได้รับการยกเวันการคำนวณชม.สอน";
                                                                                                                                    } else {
                                                                                                                                        echo " * วิชาสตูดิโอจะได้รับภาระสอนเต็มทุกคน";
                                                                                                                                    } ?></p>
                            </th>
                            <?php
                            if (!empty($_SESSION["admin"]) && $_SESSION["admin"]["auth_lv"] >= 7) {
                                if (!isset($_GET["ta"]) && !isset($_GET["hrs"])) {
                                    echo '<th class="text-end" style="width: 16em;">';
                                    if ($_SESSION["admin"]["editable"] == 'true') {
                                        echo '<a href="?' . 'p=' . $_GET["p"] . '&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '&ta=form" class="btn btn-sm btn-primary" style="font-size: 0.8em;" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มรายชื่อผู้สอนร่วมในวิชา"><i class="bi ' . $this->icon["person_add"] . ' me-1"></i>เพิ่มผู้สอนร่วม</a>';
                                    }
                                    echo '</th>';
                                } else {
                                    echo '<th></th>';
                                }
                            } else {
                                echo '<th></th>';
                            } ?>
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
                                // $user_info = $MJU_API->GetAPI_array($api_person . $cap["cap_citizenid"])[0];
                                // $user_info = "SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'";
                                $user_info = $this->get_db_row("SELECT * FROM `teacher` WHERE `citizenId` = '" . $cap["cap_citizenid"] . "'");
                                $fnc->debug_console("user_info sql: ", $user_info);
                        ?>
                                <tr class="">
                                    <td scope="row" nowrap>
                                        <?php
                                        if ($cap["cap_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 5) {
                                            echo '<a href="?p=userview&semester=' . $cap_info["cap_semester"] . '&edu_year=' . $cap_info["cap_year"] . '&cap_uid=' . $cap["cap_citizenid"] . '">' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"] . '</a>';
                                        } else {
                                            echo $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"];
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    if (isset($_GET["hrs"]) && $_GET["hrs"] == "capedit" && isset($_GET["cap_id"]) && $cap["cap_id"] == $_GET["cap_id"]) {
                                        echo '<td colspan="2">';
                                        $this->gen_hrs_form_update($cap_info, $cap["cap_lecture_hours"], $cap["cap_lab_hours"], $hrs);
                                        echo '</td>';
                                    } else {
                                        echo '<td><span nowrap>บรรยาย : ' . $cap["cap_lecture_hours"] . ' / </span><span nowrap>ปฏิบัติ : ' . $cap["cap_lab_hours"] . '</span></td>';
                                        if ($cap_info["cap_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 9) {
                                            if ($cap_info["course_lec"] != "" && $cap_info["course_lab"] != "") {
                                                echo '<td class="text-end">';
                                                if ($_SESSION["admin"]["editable"] == "true" && $cap_info["course_studio"] != "true") {
                                                    echo '<a href="?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&hrs=capedit&cap_id=' . $cap["cap_id"] . '" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="แก้ไขภาระงานสอนผู้สอนหลัก"><i class="bi ' . $this->icon["edit"] . ' me-1"></i>แก้ไขภาระงานสอน</a>';
                                                }
                                                echo '</td>';
                                            }
                                        } else {
                                            echo '<td class="text-end"></td>';
                                        }
                                    }
                                    if (!isset($_GET['ta']) && !isset($_GET['cas_id'])) {
                                        // echo '<td></td>';
                                    } else {
                                        //echo '<td>b</td>';
                                    }
                                    ?>

                                </tr>
                                <?php
                            }
                            // * get teacher assistant list adn display as table here
                            $sql = "Select * From course_active_secondary coas Where coas.cas_status = 'enable' AND coas.cap_id = " . $cap_info["cap_id"];
                            $cas_array = $fnc->get_db_array($sql);
                            $fnc->debug_console("cas_array : ", $cas_array);
                            if (!empty($cas_array)) {
                                foreach ($cas_array as $cas) {
                                    // $ta_info = $MJU_API->GetAPI_array($api_person . $cas["cas_citizenid"])[0];
                                    $ta_info = $fnc->get_db_row("SELECT titleName, firstName, lastName FROM `teacher` WHERE `citizenId` = '" . $cas["cas_citizenid"] . "'");
                                    $fnc->debug_console("ta_info sql : ", $ta_info);
                                    if (!$ta_info) {
                                    $ta_info = $fnc->get_db_row("SELECT teacher_ext_titlePosition as titlePosition, teacher_ext_firstName as firstName, teacher_ext_lastName as lastName FROM `teacher_ext` WHERE `teacher_ext_citizenid` = '" . $cas["cas_citizenid"] . "'");
                                    // $fnc->debug_console("ta_info sql : " . "SELECT * FROM `teacher_ext` WHERE `teacher_ext_citizenid` = '" . $cas["cas_citizenid"] . "'");
                                    $fnc->debug_console("ta_info ext sql : ", $ta_info);
                                    $ta_info["lastName"] .= ' (อ.พิเศษ)';
                                    }
                                ?>
                                    <tr class="">
                                        <td scope="row">

                                            <?php
                                            if ($cas["cas_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 5) {
                                                echo '<a href="?p=userview&semester=' . $cap_info["cap_semester"] . '&edu_year=' . $cap_info["cap_year"] . '&cap_uid=' . $cas["cas_citizenid"] . '">' . $ta_info["firstName"] . '&nbsp;&nbsp;' . $ta_info["lastName"] . '</a>';
                                            } else {
                                                echo $ta_info["firstName"] . '&nbsp;&nbsp;' . $ta_info["lastName"];
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        if (isset($_GET["hrs"]) && $_GET["hrs"] == "casedit" && isset($_GET["cas_id"]) && $cas["cas_id"] == $_GET["cas_id"]) {
                                            echo '<td colspan="2">';
                                            $this->gen_hrs_form_update($cap_info, $cas["cas_lecture_hours"], $cas["cas_lab_hours"], $hrs);
                                            echo '</td>';
                                        } else {
                                            echo '<td><span nowrap>บรรยาย : ' . $cas["cas_lecture_hours"] . ' / </span><span nowrap>ปฏิบัติ : ' . $cas["cas_lab_hours"] . '</span></td>';
                                            if ($cap_info["cap_citizenid"] == $_SESSION["admin"]["citizenId"] || $_SESSION["admin"]["auth_lv"] >= 7) {
                                                echo '<td class="text-end">';
                                                if ($_SESSION["admin"]["editable"] == "true" && $_SESSION["admin"]["auth_lv"] >= 9 && $cap_info["course_studio"] != "true") {
                                                    echo '<a href="?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '&hrs=casedit&cas_id=' . $cas["cas_id"] . '" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="แก้ไขภาระงานสอนผู้สอนร่วม"><i class="bi ' . $this->icon["edit"] . ' me-1"></i>แก้ไขภาระฯ</a>';
                                                }
                                                if ($_SESSION["admin"]["editable"] == "true" && $_SESSION["admin"]["auth_lv"] >= 7) {
                                                    echo '<a href="#" onclick="ta_remove_confirmation(' . $_GET["cap_cid"] . ',' . $_GET["cap_id"] . ',' . $cas["cas_id"] . ');" class="btn btn-sm btn-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="นำรายชื่อผู้สอนร่วมออก"><i class="bi ' . $this->icon["person_del"] . ' me-1"></i>นำออก</a></td>';
                                                }
                                            } else {
                                                echo '<td></td>';
                                            }
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

            <div class="text-end mt-5 mb-3 d-none">
                <!-- <input type="button" class="btn btn-secondary text-uppercase px-5" onclick="history.back();" value="close"> -->
                <input type="button" class="btn btn-secondary text-uppercase px-5" onclick="window.open('<?php echo 'index.php?p=userview&semester=' . $_SESSION["admin"]["semester"] . '&edu_year=' . $_SESSION["admin"]["edu_year"] . '&cap_uid=' . $_SESSION["admin"]["citizenId"]; ?>','_top')" value="close">
            </div>

        </div>

        <?php
        if (isset($_GET["ta"]) && $_GET["ta"] == "form") {
            $this->cas_form($cap_info, $user_info);
            // cas_table();
        }
    }

    // * display course assignment to teacher or open course activation secondary teacher
    public function cas_form($cap_info, $user_info)
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;
        ?>
        <div class="container border-bottom mb-3">
            <h4 class="text-warning bold py-2 fw-bold">เพิ่มผู้สอนร่วม</h4>
            <div class="bg-light rounded-top rounded-3 box_shadow p-4">
                <form action="../db_mgt.php" method="post" class="mt-2">
                    <div class="row g-3 mb-2">
                        <div class="col-5 col-md-7 title h4 text-primary">
                            <p class="h5 text-secondary"><?= $cap_info["course_code_th"] . ' ' . $cap_info["course_name_th"] . ' ' . $cap_info["cap_notes"]; ?></p>
                            <p class="mb-2" style="font-size: 0.65em;"><?= $cap_info["course_credit"] . ' หน่วยกิต (' . $cap_info["course_lec"] . ' , ' . $cap_info["course_lab"] . ' , ' . $cap_info["course_self"] . ' )'; ?>
                                <hr><span class="h6"><?= 'ภาคการศึกษาที่ ' . $cap_info["cap_semester"] . '/' . $cap_info["cap_year"] . ''; ?></span>
                            </p>
                            <p class="h6 mt-5 text-secondary"><?= 'เจ้าของวิชา'; ?></p>
                            <p class="h5" style=""><?= $fnc->gen_titlePosition_short($user_info["titlePosition"]) . ' ' . $user_info["firstName"] . '&nbsp;&nbsp;' . $user_info["lastName"]; ?></p>
                        </div>
                        <div class="col-7 col-md-5 form-group">
                            <?php
                            // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
                            // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
                            // $sql_cas_ext = "SELECT ext_teacher_citizenid AS citizenId, ext_teacher_titleName AS titleName, ext_teacher_titlePosition AS titlePosition, ext_teacher_firstName AS firstName, ext_teacher_lastName AS lastName FROM ext_teacher WHERE ext_teacher_status = 'enable'";
                            // foreach ($fnc->get_db_array($sql_cas_ext) as $ext_list) {
                            //     array_push($teacher_list, $ext_list);
                            // }
                            $teacher_list = $fnc->get_db_array("SELECT citizenId, titleName, titlePosition, firstName, lastName FROM teacher ORDER BY firstName");
                            // $fnc->debug_console("teacher list : ", $teacher_list);
                            $teacher_ext = $fnc->get_db_array("SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName FROM teacher_ext ORDER BY firstName");
                            // $fnc->debug_console("teacher list : ", $teacher_ext);
                            $teacher_list = array_merge($teacher_list, $teacher_ext);
                            // $fnc->debug_console("teacher merge : ", $teacher_list);
                            ?>
                            <label for="teacher" class="form-label text-dark">เลือกผู้สอนร่วม</label>
                            <select id="teacher" name="teacher" class="form-select form-select-sm" size="14" required>
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
                                            echo '>' . $t_list["firstName"] . '&nbsp;&nbsp;' . $t_list["lastName"] . ' (' . $fnc->gen_titlePosition_short($t_list["titlePosition"]) . ')' . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 py-3">
                    </div>

                    <div class="mb-3 text-end">
                        <input type="hidden" name="cap_id" value="<?= $cap_info["cap_id"] ?>">
                        <input type="hidden" name="course_id" value="<?= $cap_info["course_id"] ?>">
                        <input type="hidden" name="fst" value="casappend">
                        <button onclick="history.back();" class="btn btn-secondary text-capitalize px-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกและกลับ"><i class="bi <?= $this->icon["close"] ?> me-2"></i>close</button>
                        <button type="submit" name="ta_submit" value="ta_submit" class="btn btn-primary text-uppercase px-4 ms-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="เพิ่มผู้สอนสอนร่วมในรายวิชา"><i class="bi <?= $this->icon["person_add"] ?> me-2"></i>ลงทะเบียนสอนร่วม</button>
                    </div>
            </div>

            </form>
        </div>
        </div>
    <?php
    }

    public function get_hrs($capID, $course_id)
    {
        $fnc = $this;
        $sql = "SELECT `course_lec`*`course_lec_hrs` as max_lec_hrs, `course_lab`*`course_lab_hrs` as max_lab_hrs FROM `course` WHERE `course_id` = " . $course_id;
        $max_hrs = $fnc->get_db_array($sql)[0];
        $sql = "Select coap.cap_lecture_hours as hrs_lec, coap.cap_lab_hours as hrs_lab From course_active_primary coap Where coap.cap_id = " . $capID;
        $hrs = $fnc->get_db_array($sql);
        $sql = "Select coas.cas_lecture_hours as hrs_lec, coas.cas_lab_hours as hrs_lab From course_active_primary coap Left Join course_active_secondary coas On coap.cap_id = coas.cap_id Where coas.cas_status = 'enable' AND coap.cap_id = " . $capID;
        $ta_array = $fnc->get_db_array($sql);
        if (!empty($ta_array)) {
            foreach ($ta_array as $ta) {
                array_push($hrs, array("hrs_lec" => $ta["hrs_lec"], "hrs_lab" => $ta["hrs_lab"]));
            }
        }
        // echo "sum of hrs";
        $hrs_sum = array("lec" => 0, "lab" => 0);
        foreach ($hrs as $hr) {
            $hrs_sum["lec"] += $hr["hrs_lec"];
            $hrs_sum["lab"] += $hr["hrs_lab"];
        }
        array_push($hrs, array("hrs_lec_sum" => $hrs_sum["lec"], "hrs_lab_sum" => $hrs_sum["lab"]));
        // $fnc->debug_console("hrs max : ", $max_hrs);
        // $fnc->debug_console("hrs sum : ", $hrs);
        // echo $hrs[count($hrs) - 1]["hrs_lec_sum"] . " / " . $hrs[count($hrs) - 1]["hrs_lab_sum"];
        $max_hrs["max_lec_hrs"] = $max_hrs["max_lec_hrs"] - $hrs[count($hrs) - 1]["hrs_lec_sum"];
        $max_hrs["max_lab_hrs"] = $max_hrs["max_lab_hrs"] - $hrs[count($hrs) - 1]["hrs_lab_sum"];
        // $fnc->debug_console("hrs left : ", $max_hrs);
        echo '<span class="px-2" style="background: #888;"><span class="text-danger"> * </span>';
        echo "คงเหลือบรรยาย " . $max_hrs["max_lec_hrs"] . " ชม. และปฏิบัติ " . $max_hrs["max_lab_hrs"] . " ชม.";
        echo '</span>';
        array_push($hrs, array("hrs_lec_sum" => $hrs_sum["lec"], "hrs_lab_sum" => $hrs_sum["lab"], "max_lec_hrs" => $max_hrs["max_lec_hrs"], "max_lab_hrs" => $max_hrs["max_lab_hrs"]));
        $fnc->debug_console("hrs: ", $hrs);
        return $hrs;
    }

    public function get_hrs2($capID)
    {
        $fnc = $this;
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

    public function gen_hrs_form_update($cap_info, $hrs_lec, $hrs_lab, $hrs)
    {
        if (isset($_GET["cas_id"])) {
            echo '<form method="post" action="../db_mgt.php?act=cashrsupdate">';
            echo '<input type="hidden" name="fst" value="casHrsUpdate">';
        } else {
            echo '<form method="post" action="../db_mgt.php?act=caphrsupdate">';
            echo '<input type="hidden" name="fst" value="capHrsUpdate">';
        }
        echo '<div class="row gx-2">';
        echo '<div class="col-6 col-lg-3"><label for="hrs_lecture" class="form-label">ภาคบรรยาย</label><select class="form-select" id="hrs_lecture" name="hrs_lecture"';
        if ($cap_info["course_lec"] == 0) {
            echo ' disabled';
        }
        echo '>';
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
        echo '<div class="col-6 col-lg-3"><label for="hrs_lecture" class="form-label">ภาคปฏิบัติ</label><select class="form-select" name="hrs_laboratory"';
        if ($cap_info["course_lab"] == 0) {
            echo ' disabled';
        }
        echo '>';
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
        // echo '<a href="?p=courseview&cap_cid=' . $_GET["cap_cid"] . '&cap_id=' . $_GET["cap_id"] . '" target="_top" class="btn btn-sm btn-secondary px-4 me-2">ยกเลิก</a>';
        // echo '<input type="submit" name="submit" value="บันทึกa" class="btn btn-sm btn-primary px-4">';
        echo '<button type="submit" name="submit" value="บันทึก" class="btn btn-sm btn-primary px-4" data-bs-toggle="tooltip" data-bs-placement="top" title="บันทึกข้อมูลภาระงานสอน"><i class="bi ' . $this->icon["save"] . ' me-2"></i>บันทึก</button>';
        echo '</div>';
        echo '</form>';
    }

    public function edit_course_primary($course_id, $cap_id = NULL)
    {
        $fnc = $this;
        $sql = "SELECT * FROM `course` WHERE `course_id` =" . $course_id;
        $course_info = $fnc->get_db_row($sql);
        $fnc->debug_console("course info:", $course_info);
    ?>
        <div class="container border-bottom mb-4 text-dark">
            <p class="text-primary h3">แก้ไขข้อมูลรายวิชา</p>
            <form action="../db_mgt.php" method="post">
                <div class="card bordered p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-4 form-group">
                            <label for="course_code_th" class="form-label text-capitalize">รหัสวิชา <span class="lbl_required">*</span></label>
                            <input type="text" name="course_code_th" id="course_code_th" class="form-control" maxlength="5" value="<?= $course_info["course_code_th"]; ?>" required>
                        </div>
                        <div class="col-8 form-group">
                            <label for="course_name_th" class="form-label text-capitalize">ชื่อรายวิชา <span class="lbl_required">*</span></label>
                            <input type="text" name="course_name_th" id="course_name_th" class="form-control" maxlength="80" value="<?= $course_info["course_name_th"]; ?>" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-4 form-group">
                            <label for="course_code_en" class="form-label text-capitalize">Course Code</label>
                            <input type="text" name="course_code_en" id="course_code_en" class="form-control" maxlength="5" value="<?= $course_info["course_code_en"]; ?>">
                        </div>
                        <div class="col-8 form-group">
                            <label for="course_name_en" class="form-label text-capitalize">Course Name</label>
                            <input type="text" name="course_name_en" id="course_name_en" class="form-control" maxlength="80" value="<?= $course_info["course_name_en"]; ?>">
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3 form-group">
                            <label for="course_credit" class="form-label text-capitalize">หน่วยกิต <span class="lbl_required">*</span></label>
                            <input type="number" name="course_credit" id="course_credit" class="form-control text-center" max="20" value="<?= $course_info["course_credit"]; ?>" required>
                        </div>
                        <div class="col-6 col-md-3 form-group">
                            <label for="course_lec" class="form-label text-capitalize">ภาคบรรยาย <span class="lbl_required">*</span></label>
                            <input type="number" name="course_lec" id="course_lec" class="form-control text-center" max="10" value="<?= $course_info["course_lec"]; ?>" required>
                        </div>
                        <div class="col-6 col-md-3 form-group">
                            <label for="course_lab" class="form-label text-capitalize">ภาคปฏิบัติ <span class="lbl_required">*</span></label>
                            <input type="number" name="course_lab" id="course_lab" class="form-control text-center" max="10" value="<?= $course_info["course_lab"]; ?>" required>
                        </div>
                        <div class="col-6 col-md-3 form-group">
                            <label for="course_self" class="form-label text-capitalize">ศึกษาตัวตนเอง <span class="lbl_required">*</span></label>
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
                        <!-- <div class="col-3 text-left">
                            <div class="form-check form-switch form-group">
                                <input class="form-check-input form-control-lg align-self-end" type="checkbox" name="course_status" value="enable" id="course_status " <?php if ($course_info["course_status"] == "enable") {
                                                                                                                                                                            echo ' checked';
                                                                                                                                                                        } ?>>
                                <label class="form-check-label" for="course_status ">Open this course</label>
                            </div>
                        </div> -->
                        <div class="col-auto col-md-2 ms-auto form-group">
                            <button type="button" onclick="history.back()" class="btn btn-secondary px-4 w-100 text-capitalize" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกและกลับ"><i class="bi <?= $this->icon["close"] ?> me-2"></i>close</button>
                        </div>
                        <div class="col-6 col-md-2 form-group">
                            <input type="hidden" name="course_id" value="<?= $course_info["course_id"] ?>">
                            <input type="hidden" name="course_status" value="<?= $course_info["course_status"] ?>">
                            <input type="hidden" name="cap_id" value="<?= $_GET["cap_id"] ?>">
                            <input type="hidden" name="fst" value="courseupdate">
                            <input type="submit" name="courseupdate" value="บันทึก" class="btn btn-primary px-4 w-100">
                        </div>
                    </div>
                </div>
            </form>


        </div>

    <?php
    }

    public function course_studio_form()
    {
        $fnc = $this;
        $title_text = "จัดการรายวิชาสตูดิโอ";
    ?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_course bg-gradient">
                <h5><?= $title_text ?></h5>
            </div>
            <div class="container h-100 px-2 px-md-5 bg-light border rounded-top rounded-3 page_container_form">
                <?php
                if (isset($_GET["cap_id"])) {
                    $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                    $cap_info = $fnc->get_db_array($sql)[0];
                    // $fnc->debug_console("cap filter sql: ", $sql);
                    // $fnc->debug_console("cap filter array: ", $cap_info);
                    // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                }
                ?>
                <form action="../db_mgt.php" method="post" class="mt-4">

                    <div class="row form-group g-3 mb-3 text-dark">
                        <div class="col-5">
                            <div class="form-group">
                                <?php
                                // $sql = "SELECT cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self FROM v_cap2 
                                // WHERE cap_semester = 2 AND cap_year = '2564' 
                                // GROUP BY cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self ORDER BY course_name_th";
                                $sql = "SELECT course_id, course_code_th, course_name_th, course_studio, course_credit, course_lec, course_lab, course_self, course_status FROM course WHERE course_studio = '' AND course_status = 'enable' ORDER BY substr(course_code_th, 3, 3)";
                                $course_list = $fnc->get_db_array($sql);
                                ?>
                                <label for="course" class="form-label">รายวิชาทั่วไป</label>
                                <select id="course" name="course[]" class="form-select form-select-sm" size="23" aria-label="size 3 select example" multiple>
                                    <!-- <option selected>Open this select menu</option> -->
                                    <?php
                                    foreach ($course_list as $c_list) {
                                        echo '<option value="' . $c_list["course_id"] . '"';
                                        echo '>' . $c_list["course_code_th"] . '&nbsp;&nbsp;' . $c_list["course_name_th"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-2 align-self-center">
                            <div class="form-group">
                                <input type="hidden" name="fst" value="courseStudioAssign">
                                <button type="submit" name="btn_studio" class="btn btn-primary text-uppercase w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มรายวิชาสตูดิโอ">วิชาสตูดิโอ<i class="bi bi-chevron-double-right ms-2"></i></button>
                                <button type="submit" name="btn_general" class="btn btn-success text-uppercase w-100 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกรายวิชาสตูดิโอ"><i class="bi bi-chevron-double-left me-2"></i>วิชาทั่วไป</button>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-group">
                                <?php
                                // $sql = "SELECT cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self FROM v_cap2 
                                // WHERE cap_semester = 2 AND cap_year = '2564' 
                                // GROUP BY cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self ORDER BY course_name_th";
                                $sql = "SELECT course_id, course_code_th, course_name_th, course_studio, course_credit, course_lec, course_lab, course_self, course_status FROM course WHERE course_studio = 'studio' AND course_status = 'enable' ORDER BY substr(course_code_th, 3, 3)";
                                $course_list = $fnc->get_db_array($sql);
                                ?>
                                <label for="course_studio" class="form-label">รายวิชาสตูดิโอ</label>
                                <select id="course_studio" name="course_studio[]" class="form-select form-select-sm" size="23" aria-label="size 3 select example" multiple>
                                    <!-- <option selected>Open this select menu</option> -->
                                    <?php
                                    foreach ($course_list as $c_list) {
                                        echo '<option value="' . $c_list["course_id"] . '"';
                                        echo '>' . $c_list["course_code_th"] . '&nbsp;&nbsp;' . $c_list["course_name_th"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    <?php
    }

    public function course_zero_form()
    {
        $fnc = $this;
        $title_text = "จัดการรายวิชาไม่นับชั่วโมงสอน";
    ?>
        <div class="container border-bottom mb-4 mt-4">
            <!-- <h2 class="text-primary">Course Assign to Teacher</h2> -->
            <div class="page_header_zero_course bg-gradient">
                <h5><?= $title_text ?></h5>
            </div>
            <div class="container h-100 px-2 px-md-5 bg-light border rounded-top rounded-3 page_container_form">
                <?php
                if (isset($_GET["cap_id"])) {
                    $sql = "SELECT * FROM v_cap WHERE cap_id = " . $_GET["cap_id"];
                    $cap_info = $fnc->get_db_array($sql)[0];
                    // $fnc->debug_console("cap filter sql: ", $sql);
                    // $fnc->debug_console("cap filter array: ", $cap_info);
                    // if (isset($cap_info["cap_semester"])) { echo " value='" . $cap_info["cap_semester"] . "'"; }
                }
                ?>
                <form action="../db_mgt.php" method="post" class="mt-4">

                    <div class="row form-group g-3 pb-3 text-dark">
                        <div class="col-5">
                            <div class="form-group">
                                <?php
                                // $sql = "SELECT cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self FROM v_cap2 
                                // WHERE cap_semester = 2 AND cap_year = '2564' 
                                // GROUP BY cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self ORDER BY course_name_th";
                                $sql = "SELECT course_id, course_code_th, course_name_th, course_studio, course_credit, course_lec, course_lab, course_self, course_status FROM course WHERE course_studio = '' AND course_status = 'enable' ORDER BY substr(course_code_th, 3, 3)";
                                $course_list = $fnc->get_db_array($sql);
                                ?>
                                <label for="course" class="form-label">รายวิชาทั่วไป</label>
                                <select id="course" name="course[]" class="form-select form-select-sm" size="18" aria-label="size 3 select example" multiple>
                                    <!-- <option selected>Open this select menu</option> -->
                                    <?php
                                    foreach ($course_list as $c_list) {
                                        echo '<option value="' . $c_list["course_id"] . '"';
                                        echo '>' . $c_list["course_code_th"] . '&nbsp;&nbsp;' . $c_list["course_name_th"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-2 align-self-center">
                            <div class="form-group">
                                <input type="hidden" name="fst" value="courseStudioAssign">
                                <button type="submit" name="btn_zero" class="btn btn-primary text-capitalize w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มรายวิชาไม่นับชั่วโมงสอน">Zero Hrs<i class="bi bi-chevron-double-right ms-2"></i></button>
                                <button type="submit" name="btn_general2" class="btn btn-success text-uppercase w-100 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ยกเลิกรายวิชาไม่นับชั่วโมงสอน"><i class="bi bi-chevron-double-left me-2"></i>วิชาทั่วไป</button>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-group">
                                <?php
                                // $sql = "SELECT cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self FROM v_cap2 
                                // WHERE cap_semester = 2 AND cap_year = '2564' 
                                // GROUP BY cap_id, cap_semester, cap_year, course_id, course_code_th, course_name_th, course_credit, course_lec, course_lab, course_self ORDER BY course_name_th";
                                $sql = "SELECT course_id, course_code_th, course_name_th, course_studio, course_credit, course_lec, course_lab, course_self, course_status FROM course WHERE course_studio = 'zero' AND course_status = 'enable' ORDER BY substr(course_code_th, 3, 3)";
                                $course_list = $fnc->get_db_array($sql);
                                ?>
                                <label for="course_zero" class="form-label">รายวิชาไม่นับชั่วโมงสอน</label>
                                <select id="course_zero" name="course_zero[]" class="form-select form-select-sm" size="18" aria-label="size 3 select example" multiple>
                                    <!-- <option selected>Open this select menu</option> -->
                                    <?php
                                    foreach ($course_list as $c_list) {
                                        echo '<option value="' . $c_list["course_id"] . '"';
                                        echo '>' . $c_list["course_code_th"] . '&nbsp;&nbsp;' . $c_list["course_name_th"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
<?php
    }

    public function get_teacher_update()
    {
        $fnc = $this;
        // $MJU_API = new MJU_API;
        // $api_person_faculty = $this->api_person_faculty;

        // * get api
        // $teacher_list = $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "positionTypeId", "ก");
        // array_push($teacher_list, $MJU_API->gen_array_filter($MJU_API->GetAPI_array($api_person_faculty), "fistNameEn", "Sirichai")[0]);
        $teacher_list = $fnc->get_db_array("SELECT citizenId, titleName, titlePosition, firstName, lastName FROM teacher ORDER BY firstName");
        // $fnc->debug_console("teacher list : ", $teacher_list);
        $teacher_ext = $fnc->get_db_array("SELECT teacher_ext_citizenid AS citizenId, teacher_ext_titleName AS titleName, teacher_ext_titlePosition AS titlePosition, teacher_ext_firstName AS firstName, teacher_ext_lastName AS lastName FROM teacher_ext ORDER BY firstName");
        // $fnc->debug_console("teacher list : ", $teacher_ext);
        $teacher_list = array_merge($teacher_list, $teacher_ext);
        // $fnc->debug_console("teacher merge : ", $teacher_list);

        // * delete all db
        $sql = "DELETE FROM teacher";
        $fnc->sql_execute($sql);

        // * loop
        $sql = "";
        foreach ($teacher_list as $row) {
            $department = $fnc->get_db_col("SELECT teaching_load_department FROM teaching_load WHERE teaching_load_citizenid = '" . $row["citizenId"] . "' ORDER BY teaching_load_id DESC LIMIT 1");
            // * insert new data
            $sql .= "INSERT INTO teacher (citizenId, titleName, titlePosition, firstName, lastName, titleNameEn, fistNameEn, lastNameEn, department, positionCode, gender, personnelType, positionTypeId, positionType, position, e_mail) 
            VALUES ('" . $row["citizenId"] . "', '" . $row["titleName"] . "', '" . $row["titlePosition"] . "', '" . $row["firstName"] . "', '" . $row["lastName"] . "', '" . $row["titleNameEn"] . "', '" . $row["fistNameEn"] . "', '" . $row["lastNameEn"] . "', '" . $department . "', '" . $row["positionCode"] . "', '" . $row["gender"] . "', '" . $row["personnelType"] . "', '" . $row["positionTypeId"] . "', '" . $row["positionType"] . "', '" . $row["position"] . "', '" . $row["e_mail"] . "'); ";
        }
        // echo $sql;
        $fnc->sql_execute_multi($sql);
    }
}

class MJU_API extends CommonFnc
{
    private $api_url = "";
    public function get_api_info($title = "", $api_url, $print_r = false)
    {
        $array_data = $this->GetAPI_array($api_url);
        echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
        echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($array_data) . "</br>";
        echo "#column: " . $this->get_col_count($array_data) . "</br>";
        echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
        $this->get_col_name($array_data, true);
        echo "</span></h4><hr>";
        if ($print_r) {
            print_r($array_data);
            echo "<hr>";
        }
    }

    public function get_row_count($array, $print_r = false)
    {
        return count($array);
    }

    public function get_col_count($array, $print_r = false)
    {
        return count($array[0]);
    }

    public function get_col_name($array, $print_r = false)
    {
        if ($print_r) {
            print_r(array_keys($array[0]));
        }
        return array_keys($array[0]);
    }

    public function gen_array_filter($array, $key, $value)
    {
        $result = array();
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                array_push($result, $array[$k]);
            }
        }
        return $result;
    }

    public function get_array_filters($array, $key1, $value1, $key2 = null, $value2 = null, $key3 = null, $value3 = null, $key4 = null, $value4 = null, $key5 = null, $value5 = null)
    {
        $result = $array;
        $this->debug_console("get_array_filter2 started");

        if ($key5 && $value5) {
            $result = $this->gen_array_filter($result, $key5, $value5);
            $this->debug_console("gen_array_filter condition #5 completed");
        }
        if ($key4 && $value4) {
            $result = $this->gen_array_filter($result, $key4, $value4);
            $this->debug_console("gen_array_filter condition #4 completed");
        }
        if ($key3 && $value3) {
            $result = $this->gen_array_filter($result, $key3, $value3);
            $this->debug_console("gen_array_filter condition #3 completed");
        }
        if ($key2 && $value2) {
            $result = $this->gen_array_filter($result, $key2, $value2);
            $this->debug_console("gen_array_filter condition #2 completed");
        }
        if ($key1 && $value1) {
            $result = $this->gen_array_filter($result, $key1, $value1);
            $this->debug_console("gen_array_filter condition #1 completed");
        }

        if (count($result)) {
            $this->debug_console("#row of result : " . count($result));
            return $result;
        } else {
            return null;
        }
    }

    public function get_row($array_data, $num_row = 1, $print_r = false)
    {
        if (isset($array_data) && isset($num_row)) {
            return $array_data[$num_row];
        } else {
            return null;
        }
    }

    public function get_col($array_data, $num_row, $col_name, $print_r = false)
    {
        if (isset($array_data) && isset($num_row) && isset($col_name)) {
            if ($print_r) {
                print_r($array_data[$num_row][$col_name]);
            }
            return $array_data[$num_row][$col_name];
        } else {
            return null;
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        // return $this->get_db_col($sql);
        $database = new $this->database();
        return $database->get_db_col($sql);
    }

    function arraysearch_rownum($key, $value, $array)
    {
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                return $k;
            }
        }
        return null;
    }

    // not Supported for SSL
    /*
    Function GetAPI_array($API_URL) {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable            
        $array_data = json_decode($data, true);

        return $array_data;
    }
    */

    // update for SSL
    function GetAPI_array($API_URL)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $data = file_get_contents($API_URL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
        $array_data = json_decode($data, true);

        return $array_data;
    }

    function GetAPI_object($API_URL)
    {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable    
        $obj_data = json_decode($data); // decode the JSON to obj        
        return $obj_data;
    }
}

class Mailer extends CommonFnc
{
    public function gen_activate_link()
    {
    }

    public function gen_email($data)
    {
        $database = new Database;
        // $data = array(
        //     "receiver_address" => $_POST["receiver_address"],
        //     "receiver_name" => $_POST["receiver_address"],
        //     "from_address" => $_SESSION["admin"]["e_mail"],
        //     // "from_name" => $_POST["m_replyuser"],
        //     "from_name" => "คณะสถาปัตยกรรมศาสตร์ฯ มหาวิทยาลัยแม่โจ้",
        //     "reply_address" => "archmaejo@gmail.com",
        //     "reply_name" => "คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้",
        //     "cc_address" => "",
        //     "cc_name" => "",
        //     "cc_address1" => "",
        //     "cc_name1" => "",
        //     "cc_address2" => "",
        //     "cc_name2" => "",
        //     "subject" => "การตอบกลับข้อความสายตรงคณบดีของท่าน",
        //     "content" => $_POST["m_reply"],
        //     "next_url" => "../admin/message.php?p=read&action=replied&id=" . $_POST["m_id"]
        // );        

        // $sql = "select * from message where message_id = " . $_POST["m_id"];
        // $row = $database->get_db_row($sql);
        // $m_created = $this->get_date_semi_th($row["message_created"]);

        $content = array(
            "title" => '<div class="mb-2"><strong class="mb-2">เรียน คุณ' . $data["receiver_name"] . '</strong></div>',
            "subject" => '<div class="mb-4"><strong class="mb-2">เรื่อง ยืนยันสิทธิ์ศิษย์เก่า</strong></div>',
            "content_intro" => '',
            "content_m_memo" => '',
            "content_then" => 'ในการนี้ กดลิงค์เถอะ',
            "reply_by" => "รองคณบดีฯ",
            "reply_by_fullname" => "ผศ.พันธุ์ศักดิ์ ชัยภักดี"
        );

        $data["content"] = $this->email_content_html($content);

        // die($data["content"]);

        $_SESSION["data"] = $data;
        $this->debug_console("email data: ", $data);
        // $_SESSION["data_json"] = json_encode($data, JSON_UNESCAPED_UNICODE);
        // echo "<br>" . $_SESSION["data"] . "<hr style:margin-bottom: 1em;>";

        // $sql = "UPDATE message SET message_status='completed',message_replied=CURRENT_TIMESTAMP,message_completed=CURRENT_TIMESTAMP,message_replytext='" . $_POST["m_reply"] . "',message_replyuser='" . $_SESSION["admin"]["board_fullname"] . "',message_replyuser_position='" . $_SESSION["admin"]["board"] . "' WHERE message_id = " . $_POST["m_id"];
        // $database->sql_execute($sql);

        // header("Location:../phpmailer/mail.php?type=session&next=true");

    }

    private function email_content_html($content)
    {
        // $content_html = '<!doctype html><html lang="en">';
        $content_html = '<meta charset="UTF-8">';
        // $content_html .= '<head>';
        // $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        // $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
        // $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
        // $content_html .= '<title>ระบบสายตรงคณบดี</title>';
        $content_html .= '<style>';
        $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
        $content_html .= '.footer-text { letter-spacing: 0.1em; }';
        $content_html .= '</style>';
        // $content_html .= '</head>';

        $content_html .= '<body>';
        $content_html .= '<div class="container col-10 col-lg-8 p-2 align-self-center" style="padding: 4em;">';
        $content_html .= '<div id="title">';
        $content_html .= $content["title"] . $content["subject"];
        $content_html .= '</div>';
        $content_html .= '<div id="content" class="text-black">';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_intro"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $content["content_m_memo"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_then"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        // $content_html .= $_POST["m_reply"];
        $content_html .= '</p>';
        $content_html .= '</div>';

        $content_html .= '<br><br>';
        $content_html .= '<div id="footer" class="mt-3 text-black">';
        $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
        $content_html .= '  <div class="mt-2 col-auto offset-6">';
        $content_html .= '      <div>';
        $content_html .= $content["reply_by_fullname"];
        $content_html .= '      </div>';
        $content_html .= '  <div style="float: left; width: 50%; padding: 10px;"></div>';
        $content_html .= '      <div>';
        $content_html .= $content["reply_by"];
        $content_html .= '      </div>';
        $content_html .= '  </div>';
        $content_html .= '</div>';

        $content_html .= '<hr class="my-4">';
        $content_html .= '<div class="row mt-1 p-2" style="content: ""; display: table; clear: both;">';
        $content_html .= '<div class="col-auto" style="float: left; width: 100px; padding: 10px;"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
        $content_html .= '<div class="col text-black-50 pt-1" style="margit-top: 2em;>';
        $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
        $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
        $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"> <a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
        $content_html .= '</p>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        // $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
        $content_html .= '</body>';
        // $content_html .= '</html>';
        return $content_html;
    }

    private function email_content_html2($content)
    {
        $content_html = '<!doctype html><html lang="en">';
        $content_html .= '<meta charset="UTF-8">';
        $content_html .= '<head>';
        $content_html .= '<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $content_html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">';
        $content_html .= '<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">';
        $content_html .= '<title>ระบบสายตรงคณบดี</title>';
        $content_html .= '<style>';
        $content_html .= 'body { font-family: Kanit, sans-serif; font-size: 1rem; letter-spacing: 0.075em; color: #000; }';
        $content_html .= '.footer-text { letter-spacing: 0.1em; }';
        $content_html .= '</style>';
        $content_html .= '</head>
        
        <body>';
        $content_html .= '<div class="container col-10 col-lg-8 p-2">';
        $content_html .= '<div id="title">';
        $content_html .= $content["title"] . $content["subject"];
        $content_html .= '</div>';
        $content_html .= '<div id="content" class="text-black">';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_intro"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $content["content_m_memo"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-0" style="text-indent: 50px;">';
        $content_html .= $content["content_then"];
        $content_html .= '</p>';
        $content_html .= '<p class="mb-2" style="text-indent: 50px;">';
        $content_html .= $_POST["m_reply"];
        $content_html .= '</p>';
        $content_html .= '</div>

        <div id="footer" class="mt-3 text-black">';
        $content_html .= '<br><br>
        ';
        $content_html .= '<div class="mt-2 col-auto offset-6">';
        $content_html .= '<div>';
        $content_html .= $content["reply_by_fullname"];
        $content_html .= '</div>';
        $content_html .= '<div>';
        $content_html .= $content["reply_by"];
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>

        <hr class="my-4">';
        $content_html .= '<div class="row mt-1 p-2" style="">';
        $content_html .= '<div class="col-auto"><img src="https://arch.mju.ac.th/img/mju_logo.jpg" width="75px"></div>';
        $content_html .= '<div class="col text-black-50 pt-1">';
        $content_html .= '<p class="footer-text" style="font-size: 0.8em;">คณะสถาปัตยกรรมศาสตร์และการออกแบบสิ่งแวดล้อม มหาวิทยาลัยแม่โจ้<br>';
        $content_html .= '<sapn>63/4 ถ.เชียงใหม่-พร้าว อ.สันทราย จ.เชียงใหม่ 50290</sapn><br>';
        $content_html .= '<span>โทร 053873350</span><span class="ms-2">Email: <a href="mailto:arch@mju.ac.th">arch@mju.ac.th</a></span><br><span><a href="https://arch.mju.ac.th" target="_blank">arch.mju.ac.th</a></span><span class="ms-2"><a href="https://www.facebook.com/ArchMaejo/" target="_blank">FB: fb.com/archmaejo</a></span>';
        $content_html .= '</p>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '</div>';
        $content_html .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>';
        $content_html .= '</body>';
        $content_html .= '</html>';
        return $content_html;
    }
}
