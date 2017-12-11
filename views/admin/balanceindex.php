<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Profile;
use app\models\History;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Транзакція';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_menu') ?>

<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="admin_order_wrap">
                <div class="clearfix">
                    <?php if( count($balance_per_user) > 0 ) { ?>
                    <div class="all_user_order_block_slide">
                        <span>Розгорнути всі</span>
                    </div>
                    <?php } ?>
                </div>
                <ul class='product_user'>
                    <?php foreach($balance_per_user as $keys => $values): ?>
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
                                        <td><?= $value['operation'] ==  1 ? "Знято" : "Поповнено"  ?></td>
                                        <td><?= $value['summa'] ?> грн.</td>
                                        <td><?= $value['date'] ?></td>
                                    </tr>
                                    <?php endforeach;?>
                                <tfooter>
                                <tr>
                                    <th colspan="6">Баланс користувача: <?= History::myBalance($keys); ?> грн. </th>
                                </tr>
                                </tfooter>
                            </table>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>