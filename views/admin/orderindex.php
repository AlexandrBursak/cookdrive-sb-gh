<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Profile;
use app\models\Service;
use yii\helpers\Url;
use app\models\Product;
use yii\widgets\Pjax;
use app\models\Order;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Замовлення на ' . date("d.m.Y");
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>

<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        //TODO: потрібно адміну створювати замовлення ?
        //echo Html::a('Create Order', ['order-create'], ['class' => 'btn btn-success']);
        //debug($users);
        ?>
    </p>
    <div class="row">
        <div class="col-lg-12">
            <div class="admin_order_wrap">
                <div class="clearfix">
                    <?php if( isset($orders_per_user) && count($orders_per_user) > 0 ) { ?>
                        <div class="all_user_order_block_slide active">
                            <span>Згорнути всі</span>
                        </div>
                    <?php } ?>
                </div>
                <ul>
                    <?php if(!empty($orders_per_user)) { ?>
                    <?php foreach($orders_per_user as $keys => $values) { ?>
                    <li class="admin_order_one active">
                        <div class="user_order_block_up">
                            <div class="user_name">
                                <?= Html::img(Profile::findOne($keys)->getAvatarUrl(24), [
                                    'class' => 'img-rounded',
                                    'alt' => Profile::findOne($keys)->name,
                                ]) ?>
                                <?php echo Profile::findOne($keys)->name ; ?>
                            </div>
                        </div>
                        <div class="table-responsive">
                <?php Pjax::begin(['id' => 'items', 'enablePushState' => false]) ?>
                        <table class="table table-hover user_order_block_dn">
                            <thead>
                                <tr>
                                    <th>Назва продукту</th>
                                    <th>Ціна</th>
                                    <th>Кількість</th>
                                    <th>Загальна вартість</th>
                                    <th>Сервіс</th>
                                    <th>Операції</th>
                                </tr>
                            </thead>
                        <?php
                        $summ_all = 0;
                        foreach ($values as $key => $value) { ?>
                            <?php if (($product = Product::findOne($value['product_id'])) !== null) { ?>
                            <tr>
                                <td><?= $product->product_name ?></td>
                                <td><?= $product->price ?> грн.</td>
                                <td><?= $value['quantity'] ?> шт.</td>
                                <td><?= $product->price * $value['quantity'] ?> грн.</td>
                                <td><?= Html::a(Service::findOne($product->serv_id)->name, Url::to(Service::findOne($product->serv_id)->link, true), ['target' => '_blank']); ?></td>
                                <td>
                                    <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/user/admin/order-delete', 'id' => $value['id']], [
                                        'title' => 'Видалити',
                                        'data-confirm' => 'А ви впевнені що хочете видалити замовлення?',
                                        'data-method' => 'POST',
                                    ]) ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-retweet replace"></span>', ['/user/admin/order-update', 'id' => $value['id']], [
                                        'title' => 'Редагування замовлення',
                                        //'class' => 'replace',
                                        'data-order-id' => $value['id']
                                    ]) ?>
                                </td>
                            </tr>


                            <?php
                                    $summ_all += $product->price * $value['quantity'];
                                 }
                        } //modified if(isset(product))
                        ?>
                            <tfooter>
                                <tr>
                                    <th colspan="6">Все замовлення користувача на суму: <?=$summ_all?> грн. </th>
                                </tr>
                            </tfooter>
                        </table>
                    <?php Pjax::end(); ?>

                        </div>
                    </li>
                        <?php } ?>
                    <?php } else if(!empty($orders_per_service)) { ?>
                        <?php foreach($orders_per_service as $keys => $values) { ?>
                            <li class="admin_order_one active">
                                <div class="user_order_block_up">
                                    <div class="user_name">
                                        Сервіс: <?php echo Service::findOne($keys)->name ; ?>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <?php Pjax::begin(['id' => 'items', 'enablePushState' => false]) ?>
                                    <table class="table table-hover user_order_block_dn">
                                        <thead>
                                        <tr>
                                            <th>Назва продукту</th>
                                            <th>Ціна</th>
                                            <th>Кількість</th>
                                            <th>Загальна вартість</th>
                                        </tr>
                                        </thead>
                                        <?php

                                        $summ_all = 0;
                                        foreach ($values as $key => $value) { ?>

                                        <?php

                                            $users_id = explode(',',$value['users_id']);
                                            $users_name = '';
                                            foreach ($users_id as $ids) {
                                                $users_name.=Profile::findOne(intval($ids))->name . ' - ' . Order::find()->select('SUM(quantity) AS quantity')->where(['date' => date("Y:m:d"), 'user_id' => intval($ids), 'product_id' => $value['product_id']])->one()->quantity.  '<br />';
                                            }
                                        ?>
                                            <?php $product = Product::findOne($value['product_id']); ?>
                                            <tr>
                                                <td><a href="<?= $product->link ?>"><?= '[' . $product->category . '|' . $product->sub_category . '] ' . $product->product_name ?></a></td>
                                                <td><?= $product->price ?> грн.</td>
                                                <td><span data-toggle="tooltip" title="<?= $users_name ?>"><?= $value['quantity_sum'] ?> шт.</span></td>
                                                <td><?= $product->price*$value['quantity_sum'] ?> грн.</td>
                                            </tr>

                                            <?php
                                            $summ_all +=$product->price*$value['quantity_sum'];
                                        }
                                        ?>
                                        <tfooter>
                                            <tr>
                                                <th colspan="6">Все замовлення сервісу на суму: <?=$summ_all?> грн. </th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                    <?php Pjax::end(); ?>

                                </div>
                            </li>
                        <?php } ?>
                    <?php } else {?>
                        <h1>Замовлення відсутні</h1>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php yii\bootstrap\Modal::begin(['id'=>'pModal','header' => '<h3>Заміна замовлення</h3>',]); ?>

<?= isset($orders_per_user)?$this->render('_replace_form'):'' ?>

<?php yii\bootstrap\Modal::end();?>

<?php
$this->registerJs("
    $(document).ready(function(){
        $('[data-toggle=\"tooltip\"]').tooltip({html: true}); 
    });
    $(document).on('ready', function() {  // 'pjax:success' use if you have used pjax
           var order_id = 0;
            $('.replace').click(function(e) {
               e.preventDefault();
               $('#pModal').modal('show').find('.modal-content').load($(this).attr('href'));
               var order_id = $(this).closest('a').attr('data-order-id');
                $('#pModal').attr('data-order-id', order_id);

            });
            $('#pModal').on('replaceconfirm', function (e, obj) {
                $.ajax({
                    url:'/user/admin/order-update?id=' + obj.orderId + '&itemId=' + obj.itemId + '&qty=' + obj.qty,
                    success: function(result) {
                        $.pjax.reload({container:'[id=items]'}); 
                    },
                    error: function() {
                    }
                });
            });
        });
    ");

?>