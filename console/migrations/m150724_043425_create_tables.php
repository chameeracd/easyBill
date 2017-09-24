<?php

use yii\db\Schema;
use yii\db\Migration;

class m150724_043425_create_tables extends Migration {

    public function up() {
        $this->createTable('category', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NULL',
        ]);

        $this->createTable('item', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'price' => Schema::TYPE_DECIMAL . '( 10, 2 ) NOT NULL DEFAULT "0.00"',
            'hh_price' => Schema::TYPE_DECIMAL . '( 10, 2 ) DEFAULT NULL',
            'description' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NULL',
        ]);

        $this->addForeignKey('fk1', 'item', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('order', [
            'id' => Schema::TYPE_PK,
            'table' => Schema::TYPE_INTEGER . ' NOT NULL',
            'opened_at' => Schema::TYPE_DATETIME,
            'closed_at' => Schema::TYPE_DATETIME,
            'status' => Schema::TYPE_STRING,
            'total' => Schema::TYPE_DECIMAL . '( 10, 2 ) NOT NULL DEFAULT "0.00"',
            'inhouse' => Schema::TYPE_BOOLEAN . ' DEFAULT false',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NULL',
        ]);

        $this->createTable('order_item', [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'item_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rate' => Schema::TYPE_DECIMAL . '( 10, 2 ) NULL DEFAULT NULL',
            'qty' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
            'hh' => Schema::TYPE_BOOLEAN . ' DEFAULT false',
            'total' => Schema::TYPE_DECIMAL . '( 10, 2 ) NOT NULL DEFAULT "0.00"',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NULL',
        ]);

        $this->addForeignKey('fk2', 'order_item', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk3', 'order_item', 'item_id', 'item', 'id', 'CASCADE', 'CASCADE');
    }

    public function down() {
        $this->dropTable('order_item');
        $this->dropTable('item');
        $this->dropTable('order');
        $this->dropTable('category');
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
