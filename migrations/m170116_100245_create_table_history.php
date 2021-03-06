<?php

use yii\db\Migration;

class m170116_100245_create_table_history extends Migration
{
    public function up()
    {
        $this->createTable('history', [
            'id' => $this->primaryKey(),
            'orders_id' => $this->integer(),
            'summa' => $this->double()->notNull(),
            'operation' => $this->integer()->notNull(),
            'users_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('history');
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
