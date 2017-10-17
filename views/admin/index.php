<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use app\models\Profile;
use app\models\History;


/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \dektrium\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Управління користувачами');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<?= $this->render('/admin/_menu') ?>
<?php Pjax::begin(['id' => 'items', 'enablePushState' => false]) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel'  => $searchModel,
    'layout'       => "{items}\n{pager}",
    //'responsive' => true,
    'columns' => [
        [
            'header' => "ПІБ",
            'value' => function ($model) {
                    return Html::a(Profile::findOne($model->id)->name);
            },
            'format' => 'raw',

        ],
        'username',
        'email:email',
        /*[
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center">
                                <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                            </div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],*
        [
            'header' => Yii::t('user', 'Block status'),
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                    ]);
                }
            },
            'format' => 'raw',
        ],*/
        [
            'header' => "Баланс",
            'value' => function ($model) {
                return Html::a(History::myBalance($model->id) . ' грн.');
            },
            'format' => 'raw',
        ],
        [
            'header' => 'Редагування балансу',
            'value' => function ($model) {
                    return "<a class=\"btn btn-sm btn-success givemoney\" data-user-id=\"" . $model->id . "\">Редагувати баланс</a>";

            },
            'format' => 'raw',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{resend_password} {delete}',
            'buttons' => [
                'resend_password' => function ($url, $model, $key) {
                    if (!$model->isAdmin) {
                        return '
                    <a data-method="POST" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['resend-password', 'id' => $model->id]) . '">
                    <span title="' . Yii::t('user', 'Generate and send new password to user') . '" class="glyphicon glyphicon-envelope">
                    </span> </a>';
                    }
                },
                /*'switch' => function ($url, $model) {
                    if($model->id != Yii::$app->user->id && Yii::$app->getModule('user')->enableImpersonateUser) {
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', ['/user/admin/switch', 'id' => $model->id], [
                            'title' => Yii::t('user', 'Become this user'),
                            'data-confirm' => Yii::t('user', 'Are you sure you want to switch to this user for the rest of this Session?'),
                            'data-method' => 'POST',
                        ]);
                    }
                }*/
            ]
        ],
    ],
]); ?>
<?php Pjax::end() ?>
<?php yii\bootstrap\Modal::begin(['id'=>'bModal','header' => '<h3>Редагування балансу</h3>', 'size' => 'modal-sm']); ?>
<?= $this->render('_balance_form'); ?>
<?php yii\bootstrap\Modal::end();?>

<?php
$this->registerJs("function onReadyAndPjaxSuccess() {
    $('.givemoney').click(function(e) {
               e.preventDefault();
               $('#bModal').modal('show').find('.modal-content').load($(this).attr('href'));
               var user_id = $(this).attr('data-user-id');
                $('#bModal').attr('data-user-id', user_id);
    
            });
    $('#bModal').on('givemoneyconfirm', function (e, obj) {
        $.ajax({
            url:'/user/admin/money?id=' + obj.userId + '&summ=' + obj.summ,
            success: function(result) {
                $.pjax.reload({container:'[id=items]'}); 
            },
            error: function() {
            }
        });
    });
};

$(document).on('ready',onReadyAndPjaxSuccess);
$(document).on('pjax:success',onReadyAndPjaxSuccess);
 ");
?>
