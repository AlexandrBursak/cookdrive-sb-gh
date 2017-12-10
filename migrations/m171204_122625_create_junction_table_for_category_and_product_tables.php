<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_product`.
 * Has foreign keys to the tables:
 *
 * - `category`
 * - `product`
 */
class m171204_122625_create_junction_table_for_category_and_product_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category_product', [
            'category_id' => $this->integer(),
            'product_id' => $this->integer(),
            'PRIMARY KEY(category_id, product_id)',
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            'idx-category_product-category_id',
            'category_product',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-category_product-category_id',
            'category_product',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            'idx-category_product-product_id',
            'category_product',
            'product_id'
        );

        // add foreign key for table `product`
        $this->addForeignKey(
            'fk-category_product-product_id',
            'category_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-category_product-category_id',
            'category_product'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-category_product-category_id',
            'category_product'
        );

        // drops foreign key for table `product`
        $this->dropForeignKey(
            'fk-category_product-product_id',
            'category_product'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            'idx-category_product-product_id',
            'category_product'
        );

        $this->dropTable('category_product');
    }
}
