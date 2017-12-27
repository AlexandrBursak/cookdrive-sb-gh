<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ACategory */

$this->title = 'Update Acategory: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Acategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('/a-category/cmenu') ?>
<div class="acategory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
