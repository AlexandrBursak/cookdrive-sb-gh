<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['category/index', 'service_id' => Yii::$app->request->get('service_id')]];
// $this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-12">
            <form method="get" action="<?=\yii\helpers\Url::to(['category/search']) ?>" class="input-group">
                <input type="hidden" class="form-control" name="service_id" value="<?=Yii::$app->request->get('service_id')?>">
                <input type="text" class="form-control" name="query" placeholder="Введіть дані для пошуку">
                <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Шукати">
                    </span>
            </form>
            <div class="categori_content_wrap">
<?php if(!empty($new_arr)){?>
                <div class="categori_title">
                    <h1><?=isset($category)?$category:'' ?></h1>
                </div>
    <div class="subcategori_list">
        <ul class="clearfix">
            <?php foreach ($new_arr as $key => $value):?>
                <?php if (!empty($key)) : ?>
                <li><a href="#"><?php echo $key?></a></li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
<?php foreach ($new_arr as $key => $value):?>
                <div class="subcategori_content_wrap">
                    <?php if (!empty($key)) : ?>
                    <div class="subcategori_title">
                        <h2><?php echo $key?></h2>
                    </div>
                    <?php endif;?>
                    <div class="categori_content">
                        <ul>
    <?php foreach ($value as $key => $value):?>
                            <li>
                                <div class="catalog_product_wrap">
                                    <a href="<?= \yii\helpers\Url::to(['product/view',
                                        'service_id'=>Yii::$app->request->get('service_id'), 'category' => Yii::$app->request->get('category'),
                                        'id'=>$value['id']])?>">
                                        <div class="catalog_product_img">
                                            <img src="<?php 
                                            if (!empty($value['photo_url'])){
                                                echo $value['photo_url']; 
                                            }
                                            else {  
                                                echo "/images/no_img.png";
                                            }
                                            ?>" alt="<?php echo $value['product_name']?>">
                                            <div class="hidden_info">
                                                <p><?php echo $value['description']?></p>
                                            </div>
                                        </div>
                                        <div class="catalog_product_info_wrap">
                                            <p class="catalog_product_subcategori_title"><?php echo $value['sub_category']?></p>
                                            <h3><?php echo $value['product_name']?></h3>
                                            <p class="catalog_product_info"><?php echo $value['weight']?></p>
                                        </div>
                                        <div class="catalog_product_price">
                                            <p><?php echo $value['price']?><span> грн.</span></p>
                                        </div>
                                    </a>
                                    <div class="catalog_product_footer clearfix">
                                        <a class='add_to_cart' data-id='<?php echo $value['id']?>' href="<?= \yii\helpers\Url::to(['cart/index', 'id'=>$value['id']])?>">Замовити</a>
                                        <div class="catalog_product_quantity">
                                            <input class='qty' type="text" value="1" maxlength="3">
                                            <span class="plus"></span>
                                            <span class="minus"></span>
                                            <span class="unit">шт.</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
<?php endforeach;?>
                        </ul>
                    </div>
                </div>
<?php endforeach;?>
<?php }
else echo "<h1>Нічого не знайдено!</h1>"
?>
            </div>
        </div>
    </div>