<?php
$httpRequestBody = http_response_code(200);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/javascript; charset=utf8');
// die(__DIR__ . '/vendor/autoload.php');
require __DIR__ . '../vendor/autoload.php';

require_once("core-engine.php");
$line = new linecore();
require_once("line-flex.php");
$flex = new line_flex();
// $fnc = new core_function();

$ReplyToken = NULL;
$replyData = NULL;
$replyFlex = NULL;
$response = NULL;

$debug = array();

// * ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\AccountLinkEvent;
use LINE\LINEBot\Event\MemberJoinEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;


// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient($line->line_setting["ChannelAccessToken"]);
$bot = new LINEBot($httpClient, array('channelSecret' => $line->line_setting["ChannelSecret"]));


// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');

// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
$eventObj = $events['events'][0]; // Event Object ของ array แรก

$push_userid = NULL;
// $line->TextPush("get data - " . json_encode($eventObj));
array_push($debug, json_encode($eventObj));
// $line->TextPush("get text - " . $eventObj["message"]["text"]);

// ดึงค่าประเภทของ Event มาไว้ในตัวแปร มีทั้งหมด 7 event
$eventType = $eventObj['type'];

// สร้างตัวแปร ไว้เก็บ sourceId ของแต่ละประเภท
$userId = NULL;
$groupId = NULL;
$roomId = NULL;
// สร้างตัวแปรเก็บ source id และ source type
$sourceId = NULL;
$sourceType = NULL;
// สร้างตัวแปร replyToken และ replyData สำหรับกรณีใช้ตอบกลับข้อความ
$replyToken = NULL;
$replyData = NULL;
// สร้างตัวแปร ไว้เก็บค่าว่าเป้น Event ประเภทไหน
$is_message = NULL;
$is_postback = NULL;
$eventJoin = NULL;
$eventLeave = NULL;
$eventFollow = NULL;
$eventUnfollow = NULL;
$eventBeacon = NULL;
$eventAccountLink = NULL;
$eventMemberJoined = NULL;
$eventMemberLeft = NULL;

// เงื่อนไขการกำหนดประเภท Event 
switch ($eventType) {
    case 'message':
        $is_message = true;
        break;
    case 'postback':
        $is_Postback = true;
        break;
    case 'join':
        $eventJoin = true;
        break;
    case 'leave':
        $eventLeave = true;
        break;
    case 'follow':
        $eventFollow = true;
        break;
    case 'unfollow':
        $eventUnfollow = true;
        break;
    case 'beacon':
        $eventBeacon = true;
        break;
    case 'accountLink':
        $eventAccountLink = true;
        break;
    case 'memberJoined':
        $eventMemberJoined = true;
        break;
    case 'memberLeft':
        $eventMemberLeft = true;
        break;
}

// สร้างตัวแปรเก็บค่า userId กรณีเป็น Event ที่เกิดขึ้นใน USER
if ($eventObj['source']['userId']) {
    $userId = $eventObj['source']['userId'];
    $sourceType = "USER";
}

if ($events) {
    $ReplyToken = $events['events'][0]['replyToken'];
    $EventType = $events['events'][0]['type'];
    $SourceUserId = $events['events'][0]['source']['userId'];
    $SourceType = $events['events'][0]['source']['type'];
    $process_done = false;

    if (isset($events['events'][0]) && array_key_exists('message', $events['events'][0])) {
        $is_message = true;
        $MessageType = $events['events'][0]['message']['type'];
        $MessageText = strtolower($events['events'][0]['message']['text']);  // แปลงเป็นตัวเล็ก สำหรับทดสอบ
        $MessageID = $events['events'][0]['message']['id'];
    }
    // * ถ้าเป็น Postback Event
    // if (isset($events['events'][0]) && array_key_exists('postback', $events['events'][0])) {
    if ($is_Postback) {
        $process_done = true;
        $dataPostback = NULL;
        $paramPostback = NULL;
        parse_str($events['events'][0]['postback']['data'], $dataPostback);;
        // if (array_key_exists('params', $events['events'][0]['postback'])) {
        //     if (array_key_exists('date', $events['events'][0]['postback']['params'])) {
        //         $paramPostback = $events['events'][0]['postback']['params']['date'];
        //     }
        //     if (array_key_exists('time', $events['events'][0]['postback']['params'])) {
        //         $paramPostback = $events['events'][0]['postback']['params']['time'];
        //     }
        //     if (array_key_exists('datetime', $events['events'][0]['postback']['params'])) {
        //         $paramPostback = $events['events'][0]['postback']['params']['datetime'];
        //     }
        // }
        $paramPostback = $eventObj['getPostbackParams'];
        $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug postback:" . $is_Postback . "\n\ndataPostback= " . json_encode($dataPostback) . "\n\nparamPostback= " . json_encode($paramPostback)));

        require_once("line-postback.php");      
        
    }

    // ! ส่วนการทำงาน    
    // $process_done = false;
    // require_once("line-flex.php");
    // $flex = new line_flex();

    // require("line-action-private.php");

    if ($process_done === false) {
        // * open line default action
        require_once("line-action.php");
        // $response = $bot->pushMessage("U94b9c26beec046b69f2e5c3de8838bd0", new TextMessageBuilder("debug:\n"));

    }

    if (!empty($replyData) || !empty($json_text)) {
        if ($push_userid) {
            $response = $bot->pushMessage($push_userid, $replyData);
        } else {
            $response = $bot->replyMessage($ReplyToken, $replyData);
        }
        if (!empty($json_text)) {
            // $line->flexMessage($json_text, $eventObj['source']['userId']);
            $line->flexMessage($json_text, $userId);
        }
    } else {
        // * show not recognize text
        $replyData = new TextMessageBuilder("ขออภัยครับ เราไม่เข้าใจข้อความนี้ ลองพิมพ์ menu สิครับ.");
        $response = $bot->replyMessage($ReplyToken, $replyData);
    }

    if ($debug) {
        $line->TextPush(json_encode($debug, JSON_UNESCAPED_UNICODE), "test");
    }
    // if (!is_null($is_postback)) {
    //     $line->TextPush("is_postback - " . $content);
    // }

    if ($response->isSucceeded()) {
        echo 'Succeeded!';
        return;
    }

    // Failed
    echo $response->getHTTPStatus() . '<br>' . $response->getRawBody();
}
// $httpRequestBody = http_response_code(200);
