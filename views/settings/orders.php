<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Product;
use app\models\Service;
use yii\helpers\Url;

$this->title = Yii::t('user', 'Мої замовлення');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
    	<div class="panel panel-default">
		    <div class="panel-heading">
	            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
	        </div>
	        <div class="panel-body">
                <?php if(isset($product_user_in_date)) { ?>
	        	<div class="clearfix">
                    <?php if( count($product_user_in_date) > 1 ) { ?>
                    <div class="all_user_order_block_slide">
                        <span>Розгорнути всі</span>
                    </div>
                    <?php } ?>
                </div>
                <ul class='product_user'>
                	<?php foreach($product_user_in_date as $keys => $values): ?>
	                <li class="admin_order_one">
                        <div class="user_order_block_up">
                            <div class="user_name">
                                <p><?=  date("d.m.Y", strtotime($keys)) ?></p>
                            </div>
                        </div>
                        <div class="table-responsive user_order_block_dn">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Назва товару</th>
                                    <th>Ціна</th>
                                    <th>Кількість</th>
                                    <th>Всього</th>
                                    <th>Сервіс</th>
                                </tr>
                                </thead>
                                <?php
                                    $summ_all = 0;
                                    foreach ($values as $key => $value): ?>

		                            <tr>
		                                <td><?= $value['product_name'] ?></td>
		                                <td><?= $value['product_price'] ?> грн.</td>
		                                <td><?= $value['quantity'] ?> шт.</td>
		                                <td><?= $value['product_price'] * $value['quantity'] ?> грн.</td>
		                                <td><?= Html::a(Service::findOne($value['product_serv_id'])->name, Url::to(Service::findOne($value['product_serv_id'])->link, true), ['target' => '_blank']); ?></td>
		                            </tr>
                                        <?php $summ_all += $value['product_price'] * $value['quantity']; ?>
                                    <?php endforeach;?>
                                <tfooter>
                                    <tr>
                                        <th colspan="6">Загальна сума: <?=$summ_all?> грн. </th>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
	                </li>
	            	<?php endforeach;?>
                </ul>
                <?php }  else { ?>
                    <h1>Замовлення відсутні</h1>
                <?php }?>
	        </div>
	    </div>
    </div>
</div>