<?php

class m150129_184028_create_mobile_number_queue_relationship extends CDbMigration {

    public function up() {
      $this->addForeignKey(
              "queue_mobile_num_fk", 
              strtolower("MobileNumberRecord"), "queue_id",
              strtolower("Queue") , "queue_id"
            );
    }

    public function down() {
        $this->execute("delete from ".strtolower("MobileNumberRecord"));
        $this->dropForeignKey("queue_mobile_num_fk", strtolower("MobileNumberRecord"));
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
