<?php

use yii\db\Migration;

/**
 * Handles dropping category from table `product`.
 */
class m171204_122253_drop_category_column_from_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('product', 'category');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('product', 'category', $this->string());
    }
}
