<?php

use app\models\Product;
use app\models\History;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

    <label for="search">Сума для редагування балансу(₴):</label>
<div class="row">
        <div class="col-xs-6">
            <input type="text" class="form-control input-sm money" maxlength="5" placeholder="0">
        </div>
        <div class="dropdown col-xs-6">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Змінити
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li class="money-confirm"><input class="btn" type="button" name="" value="Поповнити баланс" style="background: none"></li>
                    <li class="money-withdraw"><input class="btn" type="button" name="" value="Зняти кошти" style="background: none"></li>
                    <li class="money-back"><input class="btn" type="button" name="" value="Повернути кошти" style="background: none"></li>
                    <li class="divider"></li>
                    <li class="money-discharge"><input class="btn" type="button" name="" value="Погасити борг" style="background: none"></li>
                </ul>
        </div>
</div>
<?php ActiveForm::end(); ?>
<?php $this->registerJs(
    '$("document").ready(function(){
        var minusPress = false;
        $(".money").keypress(function (e) {
                if (e.which != 8 && e.which != 46  && e.which !=45 && (e.which < 48 || e.which > 57)){
                    return false;
                }
                if(e.which === 45) { 
                    if(minusPress == false) {
                        minusPress = true;
                    } else {
                        if($(this).val() == "-") {
                            return false;
                        }
                      }
                }
       });
        $(".money-confirm").on("click", function() {
            var userID = $("#bModal").attr("data-user-id");
            var summ = 0;
            $("#bModal").trigger("givemoneyconfirm", {
                userId: userID, summ: $(this).closest(".row").find(".money").val()
            });      
            alert("Перезавнтажте сторінку!");      
            $("#bModal").modal("hide");
        });

        $(".money-withdraw").on("click", function() {
            var userID = $("#bModal").attr("data-user-id");
            var summ = 0;
            $("#bModal").trigger("givemoneyconfirm", {
                userId: userID, summ: $(this).closest(".row").find(".money").val()*(-1)
            });
            alert("Перезавнтажте сторінку!");
            $("#bModal").modal("hide");
        });

        $(".money-back").on("click", function() {
            var userID = $("#bModal").attr("data-user-id");
            alert("В розробці!");
        });

        $(".money-discharge").on("click", function() {
            var userID = $("#bModal").attr("data-user-id");
            var summa = $("#bModal").attr("data-user-balance");
            if(summa < 0){
                $("#bModal").trigger("givemoneyconfirm", {
                    userId: userID, summ: summa * (-1)
                });   
                alert("Борг сплаченно! Гарного дня :)");
            }
            else
                alert("Боргів нема!");
        });

    });'
);
?>