<?php

use app\models\Product;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

    <label for="search">Сумма поповненя(₴):</label>
<div class="row">
        <div class="col-xs-6">
            <input type="text" class="form-control input-sm money" maxlength="4" placeholder="0">
        </div>
        <div class="col-xs-6">
            <input type="button" value="Поповнити" class="btn btn-info money-confirm">
        </div>
</div>
<?php ActiveForm::end(); ?>
<?php $this->registerJs(
    '$("document").ready(function(){
        $(".money").keypress(function (e) {
                if (e.which < 48 || e.which > 57) {
                return false;
             }
       });
        $(".money-confirm").on("click", function() {
        var userID = $("#bModal").attr("data-user-id");
        var summ = 0;
        $("#bModal").trigger("givemoneyconfirm", {
            userId: userID, summ: $(this).closest(".row").find(".money").val()
        });
        $("#bModal").modal("hide");
    });
    });'
);
?>