<?php

use yii\db\Migration;
use yii\db\Schema;

class m170116_131905_update_order extends Migration
{
    public function up()
    {
        $this->dropTable('order');

        $this->createTable('order', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATE,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'quantity' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'price' => Schema::TYPE_DOUBLE . ' NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m170116_131905_update_order cannot be reverted.\n";

        return false;
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
