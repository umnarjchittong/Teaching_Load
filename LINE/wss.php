<?php
// header('Content-Type: text/javascript; charset=utf8');

require __DIR__ . '/vendor/autoload.php';

//Create a new soap server
$server = new soap_server();
//Configure our WSDL
$server->configureWSDL("LineArch@Maejo - Line Office Automation");

$server->register('HelloWorld', array(), array('return' => 'xsd:string'));
$server->register('getData', array('num' => 'xsd:string'), array('return' => 'xsd:string'));
$server->register('user_register_lineId', array('citizenId' => 'xsd:string', 'lineId' => 'xsd:string'), array('return' => 'xsd:string'));



function HelloWorld()
{
    return "Hello, World!";
}

function getData($num)
{
    return "i am tom - " . $num;
}

function getSQL($num)
{
    $sql = "SELECT * FROM admin_member WHERE admin_member_id = " . $num;
    return $sql;
}

function user_register_lineId($citizenId, $lineId)
{
    require ("line-bot.php");
    $fnc = new core_function();
    $result = $fnc->user_register_lineId($citizenId, $lineId);
    // $result = "OK";
    return json_encode($result);    
}

function GetUserCitizenId()
{
    require_once("line-bot.php");
    $fnc = new core_function();
}

function GetUserInfo($citizenId)
{
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
// pass our posted data (or nothing) to the soap service
$server->service(file_get_contents("php://input"));
exit();
