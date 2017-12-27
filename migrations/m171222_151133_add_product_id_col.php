<?php

use yii\db\Migration;

/**
 * Class m171222_151133_add_product_id_col
 */
class m171222_151133_add_product_id_col extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('product', 'product_id', $this->string()->after('link'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
         $this->dropColumn('product', 'product_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171222_151133_add_product_id_col cannot be reverted.\n";

        return false;
    }
    */
}
