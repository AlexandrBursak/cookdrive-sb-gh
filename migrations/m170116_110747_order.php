<?php

use yii\db\Migration;
use yii\db\Schema;

class m170116_110747_order extends Migration
{
    public function up()
    {
        $this->createTable('order', [
            'id' => Schema::TYPE_PK, 
            'date' => Schema::TYPE_DATE,
            'user-id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product-id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'number' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m170116_110747_order cannot be reverted.\n";
        $this->dropTable('order');
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
