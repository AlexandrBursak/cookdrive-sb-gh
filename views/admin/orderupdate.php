<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Редагування замовлення №: ' . $model->id ;
$subtitle = 'Замовлення користувача: ' . $model->profile->name;
$this->params['breadcrumbs'][] = ['label' => 'Замовлення', 'url' => ['orders']];
$this->params['breadcrumbs'][] = ['label' => 'Замовлення №:' . $model->id, 'url' => ['order-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагування';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= Html::encode($subtitle) ?></h2>

    <?= $this->render('_order_form', [
        'model' => $model,
    ]) ?>

</div>