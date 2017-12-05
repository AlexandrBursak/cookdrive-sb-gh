<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Нерозподілені продукти';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/admin/_menu') ?>
<script src="">

</script>
<form action="<?= \yii\helpers\Url::to(['admin/add-to-category']) ?>" method="get">

    <h2>Категорії:</h2>
    <?php
    foreach ($categories as $key => $value)
    {
        ?>
        <input id=<?= $key ?> name="category" type="radio" value=<?= "'". $value->category."'" ?> >
        <label for=<?= $key ?>><?= $value->category ?></label>
        <?php
    }
    ?>
    <br />
    <input type="submit" value="Додати до категорії">
    <br />
    <br />
    <div class="subcategori_content_wrap">
        <div class="subcategori_title">
            <h2>Нерозподілені продукти</h2>
        </div>
        <div class="categori_content">
            <ul>
                <?php foreach ($products as $key => $value):?>
                    <li>
                        <div class="catalog_product_wrap">
                            <a href="<?= \yii\helpers\Url::to(['product/view', 'service_id'=>Yii::$app->request->get('service_id'), 'category' => Yii::$app->request->get('category'),
                                'id'=>$value['id']])?>">
                                <div class="catalog_product_img">
                                    <img src="<?= !empty($value['photo_url'])
                                        ? $value['photo_url']
                                        : "/images/no_img.png"; ?>"
                                         alt="<?= $value['product_name']?>">
                                </div>
                                <div class="catalog_product_info_wrap">
                                    <h3><?= $value['product_name'] ?></h3>
                                    <input id=<?= $key ?> name="products[]" type="checkbox" value=<?= $value->id ?> >
                                </div>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
</form>


