<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $product_name
 * @property string $description
 * @property string $weight
 * @property string $ingredients
 * @property double $price
 * @property string $photo_url
 * @property string $date_add
 * @property string $sub_category
 * @property integer $serv_id
 * @property string $link
 * @property string $category
 *
 * @property CategoryProduct[] $categoryProducts
 * @property Category[] $categories
 */
class AProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name'], 'required'],
            [['description', 'weight', 'ingredients'], 'string'],
            [['price'], 'number'],
            [['date_add'], 'safe'],
            [['serv_id'], 'integer'],
            [['product_name', 'photo_url', 'sub_category', 'link', 'category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'weight' => 'Weight',
            'ingredients' => 'Ingredients',
            'price' => 'Price',
            'photo_url' => 'Photo Url',
            'date_add' => 'Date Add',
            'sub_category' => 'Sub Category',
            'serv_id' => 'Serv ID',
            'link' => 'Link',
            'category' => 'Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
  /*/  public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   /* public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('category_product', ['product_id' => 'id']);
    }*/
    
}
