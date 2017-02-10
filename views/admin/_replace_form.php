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

$data = Product::find()->select(['concat(sub_category," ",product_name) as value', 'concat("[",sub_category,"] ",product_name) as  label', 'id as id', 'photo_url', 'sub_category', 'price', 'product_name'])->asArray()->all();

?>

<?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <label for="search">Пошук продуктів:</label>

        <?php echo AutoComplete::widget([
            'id' => 'search',
            'clientOptions' => [
                'source' => $data,
                'autoFill' => true,
                'minLength' => 3,
                'open' => new JsExpression('function( event, ui ) {
                    $(".ui-autocomplete").hide();
                }
                '),
                'response' => new JsExpression('
                    function( event, ui ) {
                    var products = \'\';
                    var len_size = ui.content.length;
                    for(var product of ui.content){
                        products += \'<li class="contact"><div class="search-item"><img class="contact-image" src="\'+ product.photo_url +\'" /></div><div class="contact-info"><div class="contact-name"> \' + product.sub_category + \' </div><div class="contact-number"> \' + product.product_name +\' </div><div class="contact-price">\' + product.price +\' грн.</div></div><div class="setting"><div class="setting-part"> <label for="qty" id="qty-label" >Кількість:</label><input type="text" maxlength="3" class="form-control qty" value="1"></div><div class="setting-part"> <input type="button" class="btn btn-info replace-confirm confirm-\' + product.id +\'"  data-id="\' + product.id +\'" value="Замінити"></div></div></div></li>\';
                        $(".media-list").html(products);
                     }
                     subscribeEvents();
                     $(".qty").keypress(function (e) {
                        if (e.which < 48 || e.which > 57) {
                        return false;
                      }
                      });
                    }
                    '),
                'select' => new JsExpression('
                    function( event, ui ) {
                    $(".replace-confirm").css("display","initial");
                    $("#qty-label").css("display","initial");
                    $(".qty").css("display","initial");
                        var product = \'<li class="contact"><div class="search-item"><img class="contact-image" src="\'+ ui.item.photo_url +\'" /></div><div class="contact-info"><div class="contact-name"> \' + ui.item.sub_category + \' </div><div class="contact-number"> \' + ui.item.product_name +\' </div><div class="contact-price">\' + ui.item.price +\' грн.</div></div></div></li>\';
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

    <ul class="media-list">
    </ul>
<?php ActiveForm::end(); ?>
<?php $this->registerJs(
    '$("document").ready(function(){
        
        
    });'
);
?>