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

    <!--<p>
        <?= Html::a('Create Aproduct', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'product_name',
             'price',
             'sub_category',
             'category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
