<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Нерозподілені продукти';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/admin/_menu'); ?>

<form action="<?= \yii\helpers\Url::to(['admin/add-to-category']); ?>" method="get">
    <div class="subcategori_content_wrap">
        <?php if(isset($status)): ?>
            <div class="alert alert-<?= $status == 'error' ? 'danger' : 'success'; ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?= $status == 'error'
                        ? 'Виберіть продукти та категорію!'
                        : 'Продукти успішно перенесено!'; ?>
                </strong>
                <?= $status == 'error'
                    ? 'Щоб перемістити продукти у відповідну катеогорію необхідно їх вибрати.'
                    : 'Усі продукти перенесено до вибраної категорії.'; ?>
            </div>
        <?php endif; ?>
        <div style="padding-right: 20px;float: left">
            <div class="title">
                <h2>Категорії:</h2>
            </div>
            <?php if(count($categories) == 0): ?>
                <div style="display: flow-root;text-align: center;color: #f56a48">
                    <h2>Немає категорій</h2>
                </div>
            <?php endif; ?>
            <div class="list-group category_list" style="float: left">
                <?php foreach ($categories as $key => $value): ?>
                    <?= Html::input(
                        'radio',
                        'category',
                        $value->category, [
                            'id' => 'category_' . $key,
                            'style' => 'display: none'
                        ]);
                    ?>
                    <label style="display: block" id="label_category_<?=$key ?>"
                           for="category_<?=$key ?>"
                           onclick="selectCategory('<?=$key ?>')">
                        <?= HTML::a($value->category,null, [
                                'class' => 'list-group-item list-group-item-warning']); ?>
                    </label>
                <?php endforeach; ?>
                <br />
                <?= Html::submitButton('Додати до категорії',[
                        'class' => 'btn btn-warning']);
                ?>
            </div>
        </div>
        <div class="title">
            <h2>Нерозподілені продукти:</h2>
        </div>
        <?php if(count($products) == 0): ?>
            <div style="display: flow-root;text-align: center;color: #f56a48">
                <h2>Немає нерозподілених продуктів</h2>
            </div>
        <?php endif; ?>
        <div class="categori_content">
            <ul>
                <?php foreach ($products as $key => $value):?>
                    <li>
                        <div id="product_wrap_<?= $key ?>" class="catalog_product_wrap" style="border-width: 3px">
                            <label for="product_<?= $key ?>" onclick="selectProduct('<?= $key ?>')">
                                <div class="catalog_product_img">
                                    <span class="glyphicon glyphicon-ok selected_icon"></span>
                                    <?= Html::img(!empty($value['photo_url'])
                                            ? $value['photo_url']
                                            : "/images/no_img.png", [
                                            'alt' => $value['product_name']
                                        ]);
                                    ?>
                                    <div class="hidden_info">
                                        <p>
                                            <?= empty($value['description'])
                                                ? 'Немає опису'
                                                : $value['description'] ;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="catalog_product_info_wrap">
                                    <h3><?= $value['product_name']; ?></h3>
                                    <?= Html::input(
                                        'checkbox',
                                        'products[]',
                                        $value->id, [
                                            'id' => 'product_' . $key,
                                            'style' => 'display: none'
                                        ]);
                                    ?>
                                </div>
                            </label>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</form>


