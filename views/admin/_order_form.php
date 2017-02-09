
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use app\models\Product;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'id')->textInput() ?>

    <?php // $form->field($model, 'date')->textInput() ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>

    <?php $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>


    <?php //$form->field($model, 'serv_id')->textInput()
    $data = Product::find()->select(['id','product_name', 'sub_category'])->asArray()->all();
    $products = [];
    foreach ($data as $key => $value)
    {
        $products[] =  $value['product_name'];
    }

    ?>

    <?= $form->field($model, 'product_name')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $products,
            'select' => new JsExpression("function( event, ui ) {
                    console.log(ui);
                 }")
        ],
        'options'=>[
            'class'=>'form-control'
        ],

    ]);
    ?>
    <?= $form->field($model, 'price')->textInput() ?>

    <?php //debug($products);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сторити' : 'Редагувати', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>