<?php

use yii\db\Migration;

class m170116_100245_create_table_history extends Migration
{
    public function up()
    {
        $this->createTable('history', [
            'id' => $this->primaryKey(),
            'orders id ' => $this->integer(),
            'summa' => $this->double()->notNull(),
            'operation' => $this->integer()->notNull(),
            'users id' => $this->integer()->notNull(),
            'date' => $this->date(),
        ]);
    }

    public function down()
    {
        echo "m170116_100245_create_table_history cannot be reverted.\n";
        $this->dropTable(history);
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
