<?php

use yii\db\Migration;
use yii\db\Schema;

class m170116_110747_create_table_order extends Migration
{
    public function up()
    {
        $this->createTable('order', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATE,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'quantity' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('order');
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
