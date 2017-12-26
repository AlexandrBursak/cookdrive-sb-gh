<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ACategory;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin categories';

?>

<?= $this->render('/a-category/cmenu') ?>

<div class="acategory-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

   <!-- <p>
        <?= Html::a('Create Acategory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

</div>
