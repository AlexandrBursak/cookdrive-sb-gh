<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Profile;
use app\models\History;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Транзакція';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>

<div class="order-index" id="#balance-page">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="admin_order_wrap">
                <div class="clearfix">
                    <?php if( count($balance_per_user) > 0 ) { ?>
                    <div class="all_user_order_block_slide">
                        <span>Згорнути всі</span>
                    </div>
                    <?php } ?>
                </div>
                <ul class='product_user'>
                    <?php if(isset($balance_per_user)) : ?>
                    <?php foreach ($balance_per_user as $keys => $values) : ?>
                    <li class="admin_order_one">
                        <div class="user_order_block_up">
                            <div class="user_name">
                                <?php if(isset($keys)) : ?>
                                <?= Html::img(Profile::findOne($keys)->getAvatarUrl(24), [
                                    'class' => 'img-rounded',
                                    'alt' => Profile::findOne($keys)->name,
                                ]) ?>
                                <?php endif;?> 
                                <?php echo Profile::findOne($keys)->name ; ?>                               
                                <a class="btn btn-sm btn-success givemoney" data-user-id="<?php echo Profile::findOne($keys)->user_id ?>" data-user-balance="<?php echo History::myBalance($keys) ?>">Редагувати баланс</a></th>
                            </div>
                        </div>
                        <div class="table-responsive user_order_block_dn">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Транзакція</th>
                                    <th>Сума</th>
                                    <th>Дата</th>
                                </tr>
                                </thead>
                                <?php
                                    foreach ($values as $key => $value): ?>    
                                    <tr>
                                        <td><?= ($value['operation'] == 1 ? "Знято. Замовлення #".$value['orders_id'] :
                                                ($value['operation'] == 2 ? "Поповнено" : 
                                                ($value['operation'] == 3 ? "Знято адміністрацією" : "..."))) ?></td>
                                        <td><?= $value['summa'] ?> грн.</td>
                                        <td><?= $value['date'] ?></td>
                                    </tr>
                                    <?php endforeach;?>
                                <tfooter>
                                <tr>
                                    <th colspan="6">Баланс користувача: <?= History::myBalance($keys); ?> грн. </th>
                                </tfooter>
                            </table>
                        </div>
                    </li>
                    <?php endforeach;?>
                <?php endif;?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php yii\bootstrap\Modal::begin(['id'=>'bModal','header' => '<h3>Редагування балансу</h3>', 'size' => 'modal-sm']); ?>
<?= $this->render('_balance_form'); ?>
<?php yii\bootstrap\Modal::end();?>

<?php
$this->registerJs("function onReadyAndPjaxSuccess() {
    $('.givemoney').click(function(e) {
               e.preventDefault();
               $('#bModal').modal('show').find('.modal-content').load($(this).attr('href'));
               var user_id = $(this).attr('data-user-id');
               var summ = $(this).attr('data-user-balance');
                $('#bModal').attr('data-user-id', user_id);
                $('#bModal').attr('data-user-balance', summ);    
            });
};

$('#bModal').on('givemoneyconfirm', function (e, obj) {
    console.log('executed');
        $.ajax({
            url:'/user/admin/money?id=' + obj.userId + '&summ=' + obj.summ,
            success: function(result) {
                $.pjax.reload({container:''}); 
            },
            error: function() {
            }
        });
    });

$(document).on('ready',onReadyAndPjaxSuccess);
$(document).on('pjax:success',onReadyAndPjaxSuccess);
 ");
?>
