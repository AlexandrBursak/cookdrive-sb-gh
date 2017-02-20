<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Продукт';
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['category/index', 'service_id' => Yii::$app->request->get('service_id')]];
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['category/view','service_id' => Yii::$app->request->get('service_id'), 'category' => $category['category']]];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="categori_content_wrap">
<?php if(!empty($product)):?>
                <div class="categori_title">
                    <h1><?php echo $product->category?></h1>
                </div>
                <div class="subcategori_content_wrap">
                    <?php if (!empty($product->sub_category)) : ?>
                    <div class="subcategori_title">
                        <h2><?php echo $product->sub_category?></h2>
                    </div>
                    <?php endif;?>
                    <div class="catalog_product_wrap  product_content_wrap clearfix">
                        <div class="catalog_product_img">
                            <img src="<?php 
                            if (!empty($product->photo_url)){
                                echo $product->photo_url; 
                            }
                            else {  
                                echo "/images/no_img.png";
                            }
                            ?>" alt="<?php echo $product->product_name?>">
                        </div>
                        <div class="product_content">
                            <div class="catalog_product_info_wrap">
                                <div>
                                    <h3><?php echo $product->product_name?></h3>
                                </div>
                                <div>
                                    <span>Інгредієнти:</span>
                                    <p><?php echo $product->description?></p>
                                </div>
                                <div>
                                    <span>Вага:</span>
                                    <p class="catalog_product_info"><?php echo $product->weight?></p>
                                </div>
                            </div>
                            <div class="catalog_product_price">
                                <p><?php echo $product->price?><span> грн.</span></p>
                            </div>
                            <div class="catalog_product_footer clearfix">
                                <a class='add_to_cart' data-id='<?php echo $product->id?>' href="<?= \yii\helpers\Url::to(['cart/index', 'id'=>$product->id])?>">Замовити</a>
                                <div class="catalog_product_quantity">
                                    <input class='qty' type="text" value="1" maxlength="3">
                                    <span class="plus"></span>
                                    <span class="minus"></span>
                                    <span class="unit">шт.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php endif;?>
            </div>
        </div>
    </div>