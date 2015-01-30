<?php

class m150129_183938_create_mobile_number_record_table extends CDbMigration {


    public function up() {
        $this->createTable(strtolower('MobileNumberRecord'), array(
            "rec_id" => "pk",
            "queue_id" => "integer",
            "mobileNumber" => "string not null",
            "location" => "string",
            "region" => "string",
            "originalNetwork" => "string",
            "timezone" => "string",
            "status" => "string",
            "date_created" => "datetime",
            "date_updated" => "datetime",
        ));
    }

    public function down() {
        $this->dropTable(strtolower('MobileNumberRecord'));
        return true;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
