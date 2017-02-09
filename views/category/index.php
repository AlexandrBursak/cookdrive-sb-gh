<?php

use yii\helpers\Html;

$this->title = 'Категорії';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-lg-12">
            <form method="get" action="<?=\yii\helpers\Url::to(['category/search']) ?>" class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Введіть дані для пошуку">
                <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Шукати">
                    </span>
            </form>
            <ul class="categories_wrap">
            <?php foreach ($top as $key => $value):?>
                <li class="categori_wrap">
                    <a href="<?php echo \yii\helpers\Url::to(['category/view', 'category' => $value['category']])?> ">
                        <div>
                            <img src="/images/<?php echo $value['category'] ?>.png" alt="<?php echo $value['category'] ?>">
                        </div>
                        <span><?php echo $value['category'] ?></span>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="categori_content_wrap">
<?php if(!empty($new_arr)):?>
                <div class="categori_title">
                    <h1><?php echo $category?></h1>
                </div>
    <div class="subcategori_list">
        <ul class="clearfix">
            <?php foreach ($new_arr as $key => $value):?>
                <li><a href="#"><?php echo $key?></a></li>
            <?php endforeach;?>
        </ul>
    </div>

    <?php foreach ($new_arr as $key => $value):?>
                <div class="subcategori_content_wrap">
                    <div class="subcategori_title">
                        <h2><?php echo $key?></h2>
                    </div>
                    <div class="categori_content">
                        <ul>
    <?php foreach ($value as $key => $value):?>
                            <li>
                                <div class="catalog_product_wrap">
                                    <a href="<?= \yii\helpers\Url::to(['product/view', 'id'=>$value['id']])?>">
                                        <div class="catalog_product_img">
                                            <img src="<?php echo $value['photo_url'] ?>" alt="<?php echo $value['product_name']?>">
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
<?php endif;?>
            </div>
        </div>
    </div>