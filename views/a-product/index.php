<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin products';

?>

<?= $this->render('/a-category/cmenu') ?>

<div class="aproduct-index">

   <!-- <h1><?= Html::encode($this->title) ?></h1> -->

   <!-- <p>
        <?= Html::a('Create Aproduct', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'product_name',
            //'description:ntext',
            //'weight:ntext',
            //'ingredients:ntext',
             'price',
            // 'photo_url:url',
            // 'date_add',
             'sub_category',
            // 'serv_id',
            // 'link',
             'category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
