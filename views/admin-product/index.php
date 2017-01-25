<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_name',
            'description:ntext',
            'weight',
            'ingredients:ntext',
            // 'price',
            // 'photo_url:url',
            // 'date_add',
            // 'category',
            // 'sub_category',
            // 'serv_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
