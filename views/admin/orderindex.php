<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Profile;
use app\models\Service;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Замовлення на ' . date("Y:m:d");
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
                    <div class="all_user_order_block_slide">
                        <span>Розгорнути всі</span>
                    </div>
                </div>
                <ul>
                    <?php if(isset($orders_per_user)) { ?>
                    <?php foreach($orders_per_user as $keys => $values) { ?>
                    <li class="admin_order_one">
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
                        <!--<div class="user_order_block_dn">-->
                            <tr>
                                <td><?= $value['product_name'] ?></td>
                                <td><?= $value['price'] ?> грн.</td>
                                <td><?= $value['quantity'] ?> шт.</td>
                                <td><?= $value['price']*$value['quantity'] ?> грн.</td>
                                <td><?= Html::a(Service::findOne($value['serv_id'])->name, Url::to(Service::findOne($value['serv_id'])->link, true), ['target' => '_blank']); ?></td>
                                <td>
                                    <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/user/admin/order-delete', 'id' => $value['id']], [
                                        'title' => 'Видалити',
                                        'data-confirm' => 'А ви впевнені що хочете видалити замовлення?',
                                        'data-method' => 'POST',
                                    ]) ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-retweet"></span>', ['/user/admin/order-update', 'id' => $value['id']], [
                                        'title' => 'Редагування замовлення',
                                    ]) ?>
                                </td>
                            </tr>
                                <!--</div>-->

                        <?php
                                $summ_all +=$value['price']*$value['quantity'];
                            }
                        ?>
                            <tfooter>
                                <tr>
                                    <th colspan="6">Все замовлення користувача на суму: <?=$summ_all?> грн. </th>
                                </tr>
                            </tfooter>
                        </table>
                        </div>
                    </li>
                    <?php } ?>
                    <?php } else if(isset($orders)) { ?>
                    <li class="admin_order_one">
                        <div class="user_order_block_up">
                            <div class="user_name">
                                Загальний чек замовлення
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-hover user_order_block_dn">
                                    <thead>
                                    <tr>
                                        <th>Назва товару</th>
                                        <th>Кількість</th>
                                        <th>Ціна</th>
                                        <th>Всього</th>
                                        <th>Сервіс</th>
                                    </tr>
                                    </thead>
                                    <?php
                                        $summ_all = 0;
                                        foreach ($orders as $key => $value) { ?>
                                            <tr>
                                                <td><?= $value['product_name'] ?></td>
                                                <td><?= $value['quantity_sum'] ?> шт.</td>
                                                <td><?= $value['price'] ?> грн.</td>
                                                <td><?= $value['price']*$value['quantity_sum'] ?> грн.</td>
                                                <td><?= Html::a(Service::findOne($value['serv_id'])->name, Url::to(Service::findOne($value['serv_id'])->link, true), ['target' => '_blank']); ?></td>
                                            </tr>
                                            <?php $summ_all += $value['price']*$value['quantity_sum']; ?>

                                        <?php } ?>
                                    <tfooter>
                                        <tr>
                                            <th colspan="6">Загальна сума: <?=$summ_all?> грн. </th>
                                        </tr>
                                    </tfooter>
                                </table>
                        </div>
                    </li>

                    <?php } else {?>
                        <h1>Замовлення відсутні</h1>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <?php //debug($dataProvider); ?>
    <?php  /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'date',
            [
                'attribute' => 'user_id',
                'value' => function($data) {
                    return Html::a( $data->profile->name . ' / ID:' . $data->user_id,['/user/profile/show', 'id' => $data->user_id], ['target'=>'_blank'] );
                    //return debug($data->user_id);
                },
                'format' => 'raw',
            ],

            [
                'attribute' => 'product_id',
                'value' => function($data) {
                    return Html::a( '[' .$data->product->sub_category . '] ' . $data->product->product_name,['/product/view', 'id' => $data->product->id], ['target'=>'_blank'] );
                },
                'format' => 'raw',
            ],



            'product_name',

            [
                'attribute' => 'price',
                'value' => function($data) {
                    return $data->price  . ' грн.';
                    //return debug($data->user_id);
                },
                'format' => 'html',
            ],

          //'serv_id',
            [
                'attribute' => 'quantity',
                'value' => function($data) {
                    return $data->quantity  . ' шт.';
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'summ',
                'value' => function($data) {
                    return ($data->quantity * $data->price) . ' грн.';
                },
                'format' => 'raw',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator'=>function($action, $model){
                    //return debug($action);
                   return ['order-' . $action,'id'=>$model['id']];
                },
                'template'=>'{view} {update}  {delete}',

            ]

        ],
    ]); */ ?>
</div>