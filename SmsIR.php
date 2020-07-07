<?php

namespace SmsIr;

/**
 * Jalali date & time.
 * @author Mohammad Mahdi Gholomian.
 * @copyright 2014 mm.gholamian@yahoo.com
 */
class SmsIR
{

    private $APIURL ;
    private $APIKey ;
    private $SecretKey ;
    private $LineNumber ;
    private $UltraFastSendUrl ;


    /**
     * Gets Api Token Url.
     *
     * @return string Indicates the Url
     */
    protected function getApiTokenUrl()
    {
        return "api/Token";
    }
    /**
     * Gets API Message Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageSendUrl()
    {
        return "api/MessageSend";
    }




    /**
     * Gets API Message Receive Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageReceiveUrl()
    {

        return "api/ReceiveMessage";
    }

    /**
     * Gets API credit Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIcreditUrl()
    {
        return "api/credit";
    }

    /**
     * Gets API SMS Line Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPISMSLineUrl()

    {
        return "api/SMSLine";
    }

    /**
     * Gets API Ultra Fast Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIUltraFastSendUrl()
    {
        return "api/UltraFastSend";
    }

    /**
     * Gets API Message Send Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageReportUrl()
    {
        return "api/MessageReport";
    }


    /**
     * Gets API Verification Code Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIVerificationCodeUrl()
    {
        return "api/VerificationCode";
    }



    public function __construct($APIKey, $SecretKey, $APIURL  , $LineNumber , $UltraFastSendUrl )
    {
        $this->APIKey = $APIKey;
        $this->SecretKey = $SecretKey;
        $this->LineNumber = $LineNumber;
        $this->APIURL = $APIURL ? $APIURL :  "https://RestfulSms.com/";
        $this->UltraFastSendUrl = $UltraFastSendUrl ? $UltraFastSendUrl : "https://ws.sms.ir/";

    }
    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */
    private function _getToken()
    {
        $postData = array(
            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
            'System' => 'php_rest_v_2_0'
        );
        $postString = json_encode($postData);

        $ch = curl_init($this->APIURL.$this->getApiTokenUrl());
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        $resp = false;
        $IsSuccessful = '';
        $TokenKey = '';
        if (is_object($response)) {
            $IsSuccessful = $response->IsSuccessful;
            if ($IsSuccessful == true) {
                $TokenKey = $response->TokenKey;
                $resp = $TokenKey;
            } else {
                $resp = false;
            }
        }
        return $resp;
    }


    /**
     * Verification Code.
     *
     * @param string $Code         Code
     * @param string $MobileNumber Mobile Number
     *

     * @return string Indicates the sent sms result
     */
    public function verificationCode($Code, $MobileNumber)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = array(
                'Code' => $Code,
                'MobileNumber' => $MobileNumber,
            );

            $url = $this->UltraFastSendUrl.$this->getAPIVerificationCodeUrl();
            $VerificationCode = $this->_execute($postData, $url, $token);
            $object = json_decode($VerificationCode);

            $result = false;
            if (is_object($object)) {
                $result = $object;
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Ultra Fast Send Message.
     *
     * @param data[] $data array structure of message data
     *
     * @return string Indicates the sent sms result
     */
    public function ultraFastSend($data)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = $data;

            $url = $this->UltraFastSendUrl.$this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->_execute($postData, $url, $token);

            $object = json_decode($UltraFastSend);

            $result = false;
            if (is_object($object)) {
                $result = $object;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets Verification And Ultra fast Sent Messages Report.
     *
     * @param string $ReportType   Report Type (verification)
     * @param string $SentReturnId Sent Id
     * @param string $FromDate     Shamsi From Date
     * @param string $ToDate       Shamsi To Date
     *
     * @return string Indicates the sent sms result
     */
    public function messageReport($ReportType, $SentReturnId, $FromDate, $ToDate)
    {

        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $postData = array(
                'ReportType' => $ReportType,
                'SentReturnId' => $SentReturnId,
                'FromDate' => $FromDate,
                'ToDate' => $ToDate
            );
            $url = $this->UltraFastSendUrl.$this->getAPIMessageReportUrl();
            $MessageReport = $this->_execute($postData, $url, $token);

            $object = json_decode($MessageReport);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object;
                } else {
                    $result = $object;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets Sent Message Response By Date.
     *
     * @param string $Shamsi_FromDate     Shamsi From Date
     * @param string $Shamsi_ToDate       Shamsi To Date

     * @param string $RowsPerPage         Rows Per Page
     * @param string $RequestedPageNumber Requested Page Number
     *
     * @return string Indicates the sent sms result
     */
    public function receiveMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber)
    {

        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIMessageReceiveUrl()."?Shamsi_FromDate=".$Shamsi_FromDate."&Shamsi_ToDate=".$Shamsi_ToDate."&RowsPerPage=".$RowsPerPage."&RequestedPageNumber=".$RequestedPageNumber;
            $ReceiveMessageResponseByDate = $this->_executeGet($url, $token);

            $object = json_decode($ReceiveMessageResponseByDate);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Messages;
                } else {
                    $result = $object->Message;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }
    /**
     * Receive Message By Last Id.

     *
     * @param string $id messages id
     *
     * @return string Indicates the sent sms result
     */
    public function receiveMessageByLastId($id)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIMessageReceiveUrl()."?id=".$id;
            $ReceiveMessageByLastId = $this->_executeGet($url, $token);

            $object = json_decode($ReceiveMessageByLastId);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Messages;
                } else {
                    $result = $object->Message;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }


    /**
     * Send sms.
     *
     * @param MobileNumbers[] $MobileNumbers array structure of mobile numbers
     * @param Messages[]      $Messages      array structure of messages
     * @param string          $SendDateTime  Send Date Time

     *
     * @return string Indicates the sent sms result
     */

    public function sendMessage($MobileNumbers, $Messages, $SendDateTime = '')
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);

        if ($token != false) {
            $postData = array(
                'Messages' => $Messages,
                'MobileNumbers' => $MobileNumbers,
                'LineNumber' => $this->LineNumber,
                'SendDateTime' => $SendDateTime,
                'CanContinueInCaseOfError' => 'false'
            );

            $url = $this->APIURL.$this->getAPIMessageSendUrl();
            $SendMessage = $this->_execute($postData, $url, $token);
            $object = json_decode($SendMessage);

            $result = false;


            if (is_object($object)) {
                $result = $object;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets Sent Message Response By Date.
     *
     * @param string $Shamsi_FromDate     Shamsi From Date
     * @param string $Shamsi_ToDate       Shamsi To Date

     * @param string $RowsPerPage         Rows Per Page
     * @param string $RequestedPageNumber Requested Page Number
     *
     * @return string Indicates the sent sms result
     */
    public function sentMessageResponseByDate($Shamsi_FromDate, $Shamsi_ToDate, $RowsPerPage, $RequestedPageNumber)
    {

        $post_data = null ;

        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIMessageSendUrl()."?Shamsi_FromDate=".$Shamsi_FromDate."&Shamsi_ToDate=".$Shamsi_ToDate."&RowsPerPage=".$RowsPerPage."&RequestedPageNumber=".$RequestedPageNumber;
            $SentMessageResponseByDate = $this->_executeGet( $url , $token );

            $object = json_decode($SentMessageResponseByDate);


            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Messages;
                } else {
                    $result = $object->Message;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Sent Message Response By Id.

     *
     * @param string $id messages id
     *
     * @return string Indicates the sent sms result
     */
    public function sentMessageResponseById($id)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIMessageSendUrl()."?id=".$id;
            $SentMessageResponseById = $this->_executeGet($url, $token);

            $object = json_decode($SentMessageResponseById);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Messages;
                } else {
                    $result = $object->Message;
                }
            } else {
                $result = false;
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets Receive Message By BatchKey And PageId.
     *

     * @param string $pageId   page id for getting messages
     * @param string $batchKey sent messages batchkey
     *

     * @return string Indicates the sent sms result
     */
    public function receiveMessageByBatchKeyAndPageId($pageId, $batchKey)
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIMessageSendUrl()."?pageId=".$pageId."&batchKey=".$batchKey;
            $ReceiveMessageByBatchKeyAndPageId = $this->_executeGet($url, $token);

            $object = json_decode($ReceiveMessageByBatchKeyAndPageId);

            $result = false;

            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Messages;
                } else {
                    $result = $object->Message;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Get Sms Lines.

     *
     * @return string Indicates the sent sms result
     */
    public function getSmsLines()
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPISMSLineUrl();
            $GetSmsLines = $this->_executeGet($url, $token);


            $object = json_decode($GetSmsLines);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->SMSLines;
                } else {

                    $result = $object->Message;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key
     */

    /**
     * Get Credit.

     *
     * @return string Indicates the sent sms result
     */
    public function getCredit()
    {
        $token = $this->_getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {

            $url = $this->APIURL.$this->getAPIcreditUrl();
            $GetCredit = $this->_executeGet($url, $token);


            $object = json_decode($GetCredit);

            $result = false;
            if (is_object($object)) {
                if ($object->IsSuccessful == true) {
                    $result = $object->Credit;
                } else {

                    $result = $object->Message;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }


    /**
     * Executes the main method.
     *
     * @param string $url   url
     * @param string $token token string
     *
     * @return string Indicates the curl execute result

     */
    private function _executeGet($url, $token)
    {
        $ch = curl_init($url);

        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-sms-ir-secure-token: '.$token
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string     $url      url
     * @param string     $token    token string
     *
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token)
    {

        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-sms-ir-secure-token: '.$token
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


}
