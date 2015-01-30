<?php

class m150129_183953_create_queue_table extends CDbMigration {

    public function up() {
        $this->createTable(strtolower('Queue'), array(
            "queue_id" => "pk",
            "queue_name" => "string",
            "fileLocation" => "string",
            "queue_status" => "string",
            "date_created" => "datetime",
            "date_finished" => "datetime",
        ));
    }

    public function down() {
        $this->dropTable(strtolower('Queue'));
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
