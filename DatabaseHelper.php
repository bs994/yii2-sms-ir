<?php

namespace DatabaseHelper;

use mysqli;

/**
 * Jalali date & time.
 * @author Mohammad Mahdi Gholomian.
 * @copyright 2014 mm.gholamian@yahoo.com
 */
class DatabaseHelper
{
    private $servername;
    private $username;
    private $password;
    private $connection;
    private $db_name;

    public function __construct($host, $username, $password, $db_name)
    {
        $this->username = $username;
        $this->password = $password;
        $this->servername = $host;
        $this->db_name = $db_name;
    }

    public function connect()
    {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->db_name);
        $this->connection->set_charset("utf8mb4");

        if ($this->connection->connect_error) {
            return -1;
        }
        return 1;
    }

    public function close()
    {
        $this->connection->close();
    }


    public function submitUltraFastSendLog($data)
    {

        $VerificationCodeId = @$data->VerificationCodeId;
        $Message = @$data->Message;
        $IsSuccessful = @$data->IsSuccessful ? 1 : 0 ;
        $sql = "insert into `sms_ir_ultra_fast_send_log` (id,VerificationCodeId,IsSuccessful,Message) value (null,'$VerificationCodeId' , '$IsSuccessful', '$Message')";
        if ($this->connection->query($sql) === TRUE) {
            echo "Record inserting successfully";
        } else {
            echo "Error inserting record: " . $this->connection->error . '(' . $sql . ')';
        }
    }
    public function submitLines($data)
    {
        foreach ($data as $item) {
            $data_as_array = (array)$item;
            $ID = @$data_as_array['ID'];
            $LineNumber = $data_as_array['LineNumber'];
            $sql = "select * from `sms_ir_line_number` where `sms_ir_id` = '$ID'";
            $result = $this->connection->query($sql);


            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                }
            } else {

                $sql = "insert into `sms_ir_line_number` (id,line_number,sms_ir_id) value (null,'$LineNumber' , '$ID')";
                if ($this->connection->query($sql) === TRUE) {
                    echo "Record inserting successfully";
                } else {
                    echo "Error inserting record: " . $this->connection->error . '(' . $sql . ')';
                }

            }
        }
    }

    public function submitSmsIrLogStatusByDate($data)
    {


        foreach ($data as $item) {
            $data_as_array = (array)$item;
            $ID = @$data_as_array['ID'];
            $MobileNo = @$data_as_array['MobileNo'];
            $LineNumber = @$data_as_array['LineNumber'];
            $SMSMessageBody = @$data_as_array['SMSMessageBody'];
            $SendDateTime = $data_as_array['SendDateTime'];
            $SendDateTimeLatin = $data_as_array['SendDateTimeLatin'];
            $ToBeSentAt = @$data_as_array['ToBeSentAt'];
            $PersianSendDateTime = @$data_as_array['PersianSendDateTime'];
            $NativeDeliveryStatus = @$data_as_array['NativeDeliveryStatus'];
            $TypeOfMessage = @$data_as_array['TypeOfMessage'];
            $IsChecked = @$data_as_array['IsChecked'] ? @$data_as_array['IsChecked'] : 0;
            $IsError = @$data_as_array['IsError'] ? @$data_as_array['IsError'] : 0;


            $sql = "select * from `sms_ir_log` where `mobile_no` = '$MobileNo' and `sms_ir_id` = '$ID'";
            $result = $this->connection->query($sql);


            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    {

                        $row_id = $row['id'];

                        $sql = "UPDATE `sms_ir_log` SET 
                                        `send_date_time`='$SendDateTime', 
                                        `LineNumber`='$LineNumber', 
                                        `Sms_message_body`='$SMSMessageBody', 
                                        `SendDateTimeLatin`='$SendDateTimeLatin', 
                                        `NativeDeliveryStatus`='$NativeDeliveryStatus', 
                                        `PersianSendDateTime`='$PersianSendDateTime', 
                                        `TypeOfMessage`='$TypeOfMessage', 
                                        `ToBeSentAt`='$ToBeSentAt', 
                                        `IsChecked`='$IsChecked', 
                                        `IsError`='$IsError'
                                        WHERE 
                                        (`id`=$row_id);";

                        if ($this->connection->query($sql) === TRUE) {
                            echo "Record updated successfully";
                        } else {
                            echo "Error updating record: " . $this->connection->error;
                        }
                    }
                }
                $result->free_result();

            } else {

                $sql = "insert into `sms_ir_log` (
`id`,
`sms_ir_id`,
`mobile_no`,
`send_date_time` ,
`delivery_status`,
`Sms_message_body`,
`SendDateTimeLatin` , 
`NativeDeliveryStatus`,
`TypeOfMessage` ,
`IsChecked` ,
`IsError` 

) values (
null,
'$ID' , 
'$MobileNo',
                                        '$SendDateTime', 
                                        '$LineNumber', 
                                        '$SMSMessageBody', 
                                        '$SendDateTimeLatin', 
                                        '$NativeDeliveryStatus', 
                                       '$TypeOfMessage', 
                                      '$IsChecked', 
                                       '$IsError')";

                if ($this->connection->query($sql) === TRUE) {
                    echo "Record inserting successfully";
                } else {
                    echo "Error inserting record: " . $this->connection->error . '(' . $sql . ')';
                }

                // echo "0 results";
            }


        }


    }

    public function submitReceivedMessage($data)
    {


        foreach ($data as $item) {
            $data_as_array = (array)$item;
            $ID = @$data_as_array['ID'];
            $MobileNo = @$data_as_array['MobileNo'];
            $LineNumber = @$data_as_array['LineNumber'];
            $SMSMessageBody = @$data_as_array['SMSMessageBody'];
            $ReceiveDateTime = $data_as_array['ReceiveDateTime'];
            $LatinReceiveDateTime = $data_as_array['LatinReceiveDateTime'];
            $TypeOfMessage = @$data_as_array['TypeOfMessage'];


            $sql = "select * from `sms_ir_receive_message` where `MobileNo` = '$MobileNo' and `sms_ir_id` = '$ID'";
            $result = $this->connection->query($sql);


            if ($result && $result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    {

                        $row_id = $row['id'];

                        $sql = "UPDATE `sms_ir_log` SET 
                                        `ReceiveDateTime`='$ReceiveDateTime', 
                                        `line_number`='$LineNumber', 
                                        `SMSMessageBody`='$SMSMessageBody', 
                                        `LatinReceiveDateTime`='$LatinReceiveDateTime', 
                                        `TypeOfMessage`='$TypeOfMessage'
                                        WHERE 
                                        (`id`=$row_id);";

                        if ($this->connection->query($sql) === TRUE) {
                            //  echo "Record updated successfully";
                        } else {
                            //  echo "Error updating record: " . $this->connection->error;
                        }
                    }
                }
                $result->free_result();

            } else {

                $sql = "insert into `sms_ir_receive_message` (
`id`,
`sms_ir_id`,
`MobileNo`,
`ReceiveDateTime` ,
`LatinReceiveDateTime`,
`SMSMessageBody`,
`TypeOfMessage` ,
`line_number` 
) values (
null,
'$ID' , 
'$MobileNo',
                                        '$ReceiveDateTime', 
                                        '$LatinReceiveDateTime', 
                                        '$SMSMessageBody', 
                                        '$TypeOfMessage', 
                                       '$LineNumber')";


                if ($this->connection->query($sql) === TRUE) {
                    echo "Record inserting successfully";
                } else {
                    echo "Error inserting record: " . $this->connection->error . '(' . $sql . ')';
                }

                // echo "0 results";
            }


        }


    }


    public function submitSmsIrLogStatus($data)
    {


        foreach ($data as $key => $item) {


            $data_as_array = (array)$item;
            $ID = @$data_as_array['Id'];
            $MobileNo = @$data_as_array['MobileNo'];
            $SendDateTime = @$data_as_array['SendDateTime'];
            $PersianSendDateTime = @$data_as_array['PersianSendDateTime'];
            $IsSuccessful = @$data_as_array['IsSuccessful'];
            $Message = @$data_as_array['Message'];
            $DeliveryStatus = @$data_as_array['DeliveryStatus'];
            $SMSMessageBody = @$data_as_array['SMSMessageBody'];
            $SendIsErronous = @$data_as_array['SendIsErronous'] ? @$data_as_array['SendIsErronous'] : 0;
            $NeedsReCheck = @$data_as_array['NeedsReCheck'] ? @$data_as_array['NeedsReCheck'] : 0;
            $DeliveryStatusFetchError = @$data_as_array['DeliveryStatusFetchError'];
            $DeliveryStateID = @$data_as_array['DeliveryStateID'] ? @$data_as_array['DeliveryStateID'] : 0;
            $BatchKey = @$data_as_array['BatchKey'];

            $sql = "select * from `sms_ir_log` where `mobile_no` = '$MobileNo' and `BatchKey` = '$BatchKey'";
            $result = $this->connection->query($sql);


            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    {

                        $row_id = $row['id'];

                        $sql = "UPDATE `sms_ir_log` SET 
                                        `send_date_time`='$SendDateTime', 
                                        `delivery_status`='$DeliveryStatus', 
                                        `Sms_message_body`='$SMSMessageBody', 
                                        `send_is_Erronous`='$SendIsErronous', 
                                        `needs_re_check`='$NeedsReCheck', 
                                        `delivery_state_id`='$DeliveryStateID', 
                                        `delivery_status_fetch_error`='$DeliveryStatusFetchError', 
                                        `IsSuccessful`='$IsSuccessful', 
                                        `Message`='$Message' , 
                                        `PersianSendDateTime` = '$PersianSendDateTime'
                                        WHERE 
                                        (`id`=$row_id);";

                        if ($this->connection->query($sql) === TRUE) {
                            echo "Record updated successfully";
                        } else {
                            echo "Error updating record: " . $this->connection->error;
                        }
                    }
                }
            } else {
                echo "0 results";
            }


            $result->free_result();


        }


    }

    public function getConfigs()
    {
        $sql = "select * from `sms_ir_config` ";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    public function updateCredit($value)
    {
        $sql = "update `sms_ir_config` set `credit` = '$value' ";
        if ($this->connection->query($sql) === TRUE) {
            return 1;
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
            return -1;
        }
    }

    public
    function submitSmsIrLogStatusById($data_as_array)
    {


        $ID = @$data_as_array['ID'];
        $MobileNo = @$data_as_array['MobileNo'];
        $SendDateTime = @$data_as_array['SendDateTime'];
        $IsSuccessful = @$data_as_array['IsSuccessful'] ? @$data_as_array['IsSuccessful'] : 0;
        $Message = @$data_as_array['Message'];
        $DeliveryStatus = @$data_as_array['DeliveryStatus'];
        $SMSMessageBody = @$data_as_array['SMSMessageBody'];
        $SendIsErronous = @$data_as_array['SendIsErronous'] ? @$data_as_array['SendIsErronous'] : 0;
        $NeedsReCheck = @$data_as_array['NeedsReCheck'] ? @$data_as_array['NeedsReCheck'] : 0;
        $DeliveryStatusFetchError = @$data_as_array['DeliveryStatusFetchError'];
        $DeliveryStateID = @$data_as_array['DeliveryStateID'] ? @$data_as_array['DeliveryStateID'] : 0;
        $BatchKey = @$data_as_array['BatchKey'];

        $sql = "select * from `sms_ir_log` where `mobile_no` = '$MobileNo' and `sms_ir_id` = '$ID'";
        $result = $this->connection->query($sql);


        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                {

                    $row_id = $row['id'];

                    $sql = "UPDATE `sms_ir_log` SET 
                                        `send_date_time`='$SendDateTime', 
                                        `delivery_status`='$DeliveryStatus', 
                                        `Sms_message_body`='$SMSMessageBody', 
                                        `send_is_Erronous`='$SendIsErronous', 
                                        `needs_re_check`='$NeedsReCheck', 
                                        `delivery_state_id`='$DeliveryStateID', 
                                        `delivery_status_fetch_error`='$DeliveryStatusFetchError'
                                        WHERE 
                                        (`id`=$row_id);";

                    if ($this->connection->query($sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $this->connection->error;
                    }
                }
            }
        } else {
            echo "0 results";
        }


        $result->free_result();


    }


    public
    function submitErrorLog($data)
    {
        $Message = $data['Message'];
        $created_at = time();

        $sql = "INSERT INTO `sms_ir_error_log` 
(`id`, `message`, `created_at` ) 
VALUES 
(NULL, '$Message', '$created_at' );";


        if ($this->connection->query($sql) === TRUE) {
            return 1;
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
            return -1;
        }

    }

    public
    function submitSmsIrLog($data)
    {

        $BatchKey = $data['BatchKey'];
        $IsSuccessful = $data['IsSuccessful'];
        $Message = $data['Message'];

        foreach ($data['Ids'] as $item) {
            $ID = $item->ID;
            $MobileNo = $item->MobileNo;
            $sql = "INSERT INTO `sms_ir_log` 
(`id`, `mobile_no`, `sms_ir_id` , `BatchKey` , `IsSuccessful` , `Message`) 
VALUES 
(NULL, '$MobileNo', '$ID' , '$BatchKey' , '$IsSuccessful', '$Message');";
            if ($this->connection->query($sql) === TRUE) {

            } else {
                echo "Error: " . $sql . "<br>" . $this->connection->error;

            }
        }
    }

}
