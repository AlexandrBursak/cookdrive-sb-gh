<?php

use yii\db\Migration;
use yii\db\Schema;


class m170116_095557_create_table_product extends Migration
{
    public function up()
    {
        $this->createTable('product', [
            'id' => Schema::TYPE_PK,
            'product_name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'weight' => Schema::TYPE_STRING . '(255) NOT NULL',
            'ingredients' => Schema::TYPE_TEXT,
            'price' => Schema::TYPE_DOUBLE,
            'photo_url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'date_add' => Schema::TYPE_DATE,
            'serv_id' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        echo "m170116_095557_create_table_product cannot be reverted.\n";

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
