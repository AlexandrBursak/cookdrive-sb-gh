<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AProduct */

$this->title = 'Create Aproduct';
$this->params['breadcrumbs'][] = ['label' => 'Aproducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aproduct-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
