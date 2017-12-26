<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Product;
use app\models\Service;
use app\models\History;
use yii\helpers\Url;

$this->title = Yii::t('user', 'Мій баланс');
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
                <p class="balance_before">Ваш баланс<span><?= History::myBalance(\Yii::$app->user->id)." грн.";  if(isset($balance_user_in_date)) { ?>
                <div class="clearfix">
                    <?php if( count($balance_user_in_date) > 0 ) { ?>
                    <div class="all_user_order_block_slide">
                        <span>Розгорнути всі</span>
                    </div>
                    <?php } ?>
                </div>
                <ul class='product_user'>
                    <?php foreach($balance_user_in_date as $keys => $values): ?>
                    <li class="admin_order_one">
                        <div class="user_order_block_up">
                            <div class="user_name">
                                <p><?=  date("Y-m-d", strtotime($keys)) ?></p>
                            </div>
                        </div>
                        <div class="table-responsive user_order_block_dn">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Operation</th>
                                    <th>Summa</th>
                                    <th>Date</th>
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
                            </table>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
                <?php }  else { ?>
                    <h1>Транзакцій не знайдено</h1>
                <?php }?>
            </div>
        </div>
    </div>
</div>