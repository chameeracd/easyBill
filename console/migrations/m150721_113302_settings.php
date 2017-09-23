<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_113302_settings extends Migration {

    public function up() {
        $this->createTable('setting', [
            'id' => Schema::TYPE_PK,
            'key' => Schema::TYPE_STRING . ' NOT NULL',
            'value' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down() {
        $this->dropTable('setting');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
