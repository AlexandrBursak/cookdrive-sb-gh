<?php

use yii\db\Migration;

class m170116_165100_update_order_add_serv_id extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'serv_id', $this->integer()->after('price'));
    }

    public function down()
    {
        echo "m170116_165100_update_order_add_serv_id cannot be reverted.\n";

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
