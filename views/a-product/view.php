<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AProduct */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aproducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aproduct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_name',
            'description:ntext',
            'weight:ntext',
            'ingredients:ntext',
            'price',
            'photo_url:url',
            'date_add',
            'sub_category',
            'serv_id',
            'link',
            'category',
        ],
    ]) ?>

</div>
