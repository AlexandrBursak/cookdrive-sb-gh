
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use app\models\Service;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'id')->textInput() ?>

    <?php // $form->field($model, 'date')->textInput() ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true])->hiddenInput()?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'serv_id')->textInput()/*->widget(AutoComplete::classname(), [
        'clientOptions' => [
            'source' => Service::find()->all(),
        ],
    ])*/ ?>

    <?php //debug(Service::find()->select('name')->asArray()->all()); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сторити' : 'Редагувати', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>