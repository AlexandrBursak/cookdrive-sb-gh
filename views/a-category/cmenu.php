<?php
/**
 * Created by PhpStorm.
 * User: Yaroslav
 * Date: 05.12.2017
 * Time: 13:35
 */
use yii\bootstrap\Nav;

?>
<?= $this->params['breadcrumbs'][] = $this->title; ?>

<?= $this->render('/admin/_menu') ?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label' => 'Категорії',
            'url' => ['/a-category/index'],
        ],
        [
            'label' => 'Страви',
            'url' => ['/a-product/index'],
        ],
    ],
]) ?>
