<?php
/**
 * Created by PhpStorm.
 * User: mosi
 * Date: 7/7/20
 * Time: 7:30 PM
 */

use DatabaseHelper\DatabaseHelper;

require "/var/www/html/yii2-sms-ir-extension/SmsIR.php";
require "/var/www/html/yii2-sms-ir-extension/DatabaseHelper.php";




$connection = new DatabaseHelper('localhost' , 'root' , '2y7hhw3gv5' , 'cms');
$connection->connect();

$configs = $connection->getConfigs();
$APIKey = $configs['api_key'];
$SecretKey = $configs['secret_key'];
$LineNumber = $configs['line_number'];
$APIURL = $configs['api_url'];
$UltraFastSendUrl = $configs['ultra_fast_send_url'];
$credit = $configs['credit'];

$sms_ir_obj = new \SmsIr\SmsIR($APIKey, $SecretKey, $APIURL, $LineNumber , $UltraFastSendUrl);

// Sending Bulk Message

/*$MobileNumbers = array('09124423166', '09335556196'  );
$Messages = array('text1' , 'text2' );
@$SendDateTime = date("Y-m-d") . "T" . date("H:i:s");
$SendMessage = $sms_ir_obj->sendMessage($MobileNumbers, $Messages, $SendDateTime);
$data = (array) $SendMessage ;
if ( $data['IsSuccessful'])
{
    $connection->submitSmsIrLog( $data );
}else {
    $connection->submitErrorLog($data);
}
*/

// Report By BatchKey
/*$batchKey = '9620a8ff-ba5e-4abc-8f1e-2a55c8d6d2a2';
$pageId = 0;

$ReceiveMessageByBatchKeyAndPageId = $sms_ir_obj->receiveMessageByBatchKeyAndPageId($pageId, $batchKey);
$data = (array) $ReceiveMessageByBatchKeyAndPageId ;
$connection->submitSmsIrLogStatus( $data );*/



// Report By Date
/*$Shamsi_FromDate = '1398/04/1';
$Shamsi_ToDate = '1399/04/31';
$RowsPerPage = 100;
$RequestedPageNumber = 1;

$SentMessageResponseByDate = $sms_ir_obj->sentMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber);

$response_array  =  (array) $SentMessageResponseByDate;

while ( count($response_array) > 0 )
{

    $SentMessageResponseByDate = $sms_ir_obj->sentMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber);
    $response_array  =  (array) $SentMessageResponseByDate;
    $connection->submitSmsIrLogStatusByDate($response_array);
    $RequestedPageNumber++;
}
*/


// Report By Id
/*$id = "30542696";

$SentMessageResponseById = $sms_ir_obj->sentMessageResponseById($id);
$data = (array) $SentMessageResponseById ;
$connection->submitSmsIrLogStatusById($data);*/


// update credit
/*$credit = $sms_ir_obj->getCredit();
$connection->updateCredit($credit);*/

// get last sms recieved message by id
/*
$ReceiveMessageByLastId = $sms_ir_obj->receiveMessageByLastId($id);
var_dump($ReceiveMessageByLastId);*/



// get Recieved Message by date

/*$Shamsi_FromDate = '1399/01/1';
$Shamsi_ToDate = '1399/04/31';
$RowsPerPage = 100;
$RequestedPageNumber = 1;

$ReceiveMessageResponseByDate = $sms_ir_obj->receiveMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber);

$data = (array) $ReceiveMessageResponseByDate ;
while ( count($data) > 0 )
{
    $ReceiveMessageResponseByDate = $sms_ir_obj->receiveMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber);
    $data  =  (array) $ReceiveMessageResponseByDate;
    $connection->submitReceivedMessage($data);
    $RequestedPageNumber++;
}*/


// Get Sms Lines

/*$GetSmsLines = $sms_ir_obj->getSmsLines();
$data = (array) $GetSmsLines ;
$connection->submitLines($data);*/



// Ultra Fast Send

/*$data = array(
    "ParameterArray" => array(
        array(
            "Parameter" => "VerificationCode",
            "ParameterValue" => "123456"
        ),
    ),
    "Mobile" => "09124423166",
    "TemplateId" => "17657"
);

$UltraFastSend = $sms_ir_obj->ultraFastSend($data);
$connection->submitUltraFastSendLog($UltraFastSend);*/


// verification sms report
/*$ReportType = 'verification';
$SentReturnId = null;
$FromDate = '1399/04/01';
$ToDate = '1399/04/21';

$MessageReport = $sms_ir_obj->messageReport($ReportType, $SentReturnId, $FromDate, $ToDate);
var_dump($MessageReport);*/


// send verification code
/*$Code = "12345";
$MobileNumber = "09124423166";
$VerificationCode = $sms_ir_obj->verificationCode($Code, $MobileNumber);
$connection->submitUltraFastSendLog($VerificationCode);
*/

$connection->close();