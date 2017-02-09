<?php

use yii\db\Migration;

class m170209_154216_product_columns extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'link', $this->string()->after('serv_id'));
    }

    public function down()
    {
        echo "m170209_154216_product_columns cannot be reverted.\n";

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
