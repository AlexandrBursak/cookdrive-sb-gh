<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CategoryProduct[] $categoryProducts
 * @property Product[] $products
 */
class ACategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
  /*  public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['category_id' => 'id']);
    }
*/
    /**
     * @return \yii\db\ActiveQuery
     */
  /*  public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('category_product', ['category_id' => 'id']);
    }*/
}
