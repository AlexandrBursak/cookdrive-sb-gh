<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 08.02.2017
 * Time: 10:49
 */
use app\models\Product;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$data = Product::find()->select(['concat(sub_category," ",product_name) as value', 'concat("[",sub_category,"] ",product_name) as  label', 'id as id', 'photo_url', 'sub_category'])->asArray()->all();

?>

<?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <label for="search">Пошук продуктів:</label>

        <?php echo AutoComplete::widget([
            'id' => 'search',
            'clientOptions' => [
                'source' => $data,
                'autoFill' => true,
                'select' => new JsExpression('
                    function( event, ui ) {
                    $(".replace-confirm").css("display","initial");
                    $("#qty-label").css("display","initial");
                    $(".qty").css("display","initial");
                        var product = \'<li class="contact"><img class="contact-image" src="\'+ ui.item.photo_url +\'" width="60px" height="60px" /><div class="contact-info"><div class="contact-name"> \' + ui.item.sub_category + \' </div><div class="contact-number"> \' + ui.item.value +\' </div></div></li>\';
                       $(".media-list").html(product);
                       $(".replace-confirm").attr(\'data-id\', ui.item.id);
                    }
                    ')

            ],
            'options' => [
                'class' => 'form-control'
            ],
        ]);?>
    </div>
    <div class="form-inline">
        <div class="col-xs-6">
            <label for="qty" id="qty-label" style="display: none;">Кількість:</label>
            <input type="text" class="form-control qty" style="display: none;" value="1" id="qty">
        </div>
        <div class="col-xs-6">
            <input type="button" class="btn btn-info replace-confirm" style="display: none;" value="Замінити">
        </div>

    </div>


    <ul class="media-list">
    </ul>
<?php ActiveForm::end(); ?>
<?php $this->registerJs(
    '$("document").ready(function(){
        var subscribeEvents = function() {
            $(".replace-confirm").on("click", function() {
            var orderID = $("#pModal").attr("data-order-id");
            var qty = $(".qty").val();
                $("#pModal").trigger("replaceconfirm", { 
                    orderId: orderID, itemId: $(this).attr("data-id"), qty: qty
                });
                $("#pModal").modal("hide");
            });
        };
        
        $("#search-form").on("pjax:end", function() {
            subscribeEvents();
        });
        
        subscribeEvents();
    });'
);
?>