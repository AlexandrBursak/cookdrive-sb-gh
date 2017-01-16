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
        echo "m170116_110500_create_table_services cannot be reverted.\n";

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
