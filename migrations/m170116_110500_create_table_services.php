<?php

use yii\db\Migration;

class m170116_110500_create_table_services extends Migration
{
    public function up()
    {
        $this->createTable('service',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
        ]);

    }

    public function down()
    {
        $this->dropTable('service');
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
