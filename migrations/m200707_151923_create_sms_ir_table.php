<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%sms_ir}}`.
 */
class m200707_151923_create_sms_ir_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('sms_ir_log', [
            'id' => Schema::TYPE_PK,
            'mobile_no' => Schema::TYPE_STRING . ' NOT NULL',
            'send_date_time' => Schema::TYPE_STRING,
            'delivery_status' => Schema::TYPE_STRING,
            'Sms_message_body' => Schema::TYPE_TEXT,
            'send_is_Erronous' => Schema::TYPE_BOOLEAN,
            'needs_re_check' => Schema::TYPE_BOOLEAN,
            'delivery_state_id' => Schema::TYPE_BIGINT,
            'sms_ir_id' => Schema::TYPE_BIGINT,
            'delivery_status_fetch_error' => Schema::TYPE_STRING ,
            'BatchKey' => Schema::TYPE_TEXT ,
            'IsSuccessful' => Schema::TYPE_BOOLEAN,
            'Message' => Schema::TYPE_STRING ,
            'PersianSendDateTime' => Schema::TYPE_STRING ,
            'LineNumber' =>  Schema::TYPE_STRING ,
            'SendDateTimeLatin' =>  Schema::TYPE_STRING ,
            'ToBeSentAt' =>   Schema::TYPE_STRING ,
            'NativeDeliveryStatus' =>  Schema::TYPE_STRING ,
            'TypeOfMessage' =>  Schema::TYPE_STRING ,
            'IsChecked' =>  Schema::TYPE_BOOLEAN ,
            'IsError' =>  Schema::TYPE_BOOLEAN



        ], $tableOptions);
        $this->createTable('sms_ir_error_log', [
            'id' => Schema::TYPE_PK,
            'created_at' => Schema::TYPE_INTEGER,
            'message' => Schema::TYPE_TEXT,
        ]);
        $this->createTable('sms_ir_line_number', [
            'id' => Schema::TYPE_PK,
            'line_number' => Schema::TYPE_STRING,
            'sms_ir_id' => Schema::TYPE_BIGINT,
        ]);


        $this->createTable('sms_ir_config', [
            'id' => Schema::TYPE_PK,
            'api_key' => Schema::TYPE_STRING,
            'secret_key' => Schema::TYPE_STRING,
            'api_url' => Schema::TYPE_STRING,
            'line_number' => Schema::TYPE_STRING,
            'credit' => Schema::TYPE_STRING,
            'ultra_fast_send_url' => Schema::TYPE_STRING
        ]);
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('sms_ir_receive_message', [
            'id' => Schema::TYPE_PK,
            'sms_ir_id' => Schema::TYPE_BIGINT,
            'line_number' => Schema::TYPE_STRING,
            'SMSMessageBody' => Schema::TYPE_TEXT,
            'MobileNo' => Schema::TYPE_STRING,
            'ReceiveDateTime' => Schema::TYPE_STRING,
            'LatinReceiveDateTime' => Schema::TYPE_STRING,
            'TypeOfMessage' => Schema::TYPE_STRING
        ] , $tableOptions);

        $this->createTable('sms_ir_ultra_fast_send_log', [
            'id' => Schema::TYPE_PK,
            'VerificationCodeId' => Schema::TYPE_STRING,
            'IsSuccessful' => Schema::TYPE_BOOLEAN,
            'Message' => Schema::TYPE_STRING
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sms_ir_log}}');
    }
}
