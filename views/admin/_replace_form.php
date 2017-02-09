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
    <div class="form-inline">
        <label for="search">Пошук продуктів:</label>

        <?php echo AutoComplete::widget([
            'id' => 'search',
            'clientOptions' => [
                'source' => $data,
                'autoFill' => true,
                'select' => new JsExpression('
                    function( event, ui ) {
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

        <input type="button" class="btn btn-info replace-confirm" value="Замінити">
    </div>

    <ul class="media-list">
    </ul>
<?php ActiveForm::end(); ?>
<?php
//debug($data);

$this->registerJs(
    '$("document").ready(function(){
        var subscribeEvents = function() {
            $(".replace-confirm").on("click", function() {
            var orderID = $("#pModal").attr("data-order-id");
                $("#pModal").trigger("replaceconfirm", { 
                    orderId: orderID, itemId: $(this).attr("data-id") 
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