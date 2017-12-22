<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ACategory */

$this->title = 'Create Acategory';
$this->params['breadcrumbs'][] = ['label' => 'Acategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/a-category/cmenu') ?>
<div class="acategory-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
