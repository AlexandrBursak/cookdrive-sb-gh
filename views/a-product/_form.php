<?php

use app\models\ACategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aproduct-form">


    <?php $form = ActiveForm::begin(); ?>
    <? $category = ACategory::find()->all();
    $items = ArrayHelper::map($category,'name','name');?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropDownList($items); ?>
    <!--<?// $form->field($model, 'category')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'weight')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ingredients')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'photo_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_add')->textInput() ?>

    <?= $form->field($model, 'sub_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serv_id')->textInput() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
