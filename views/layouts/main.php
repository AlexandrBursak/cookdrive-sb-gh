<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use dektrium\user\widgets\Connect;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php/*
echo '<pre>';
$param = Yii::$app->user->profile;
var_dump($param);
echo '</pre>';*/
?>
Yii::$app->user->identity
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $session = Yii::$app->session;
    $qty_head = $session['cart.qty'];
    $qty_head = !$qty_head ? 0 : $qty_head;
    NavBar::begin([
        'brandLabel' => 'My food',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            // ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],
            [
                'label' => $qty_head . ' шт.', 
                'url' => ['/cart/index'],
                'options' => ['class' => 'cart_navbar']
            ],
            Yii::$app->user->isGuest ? (
                '<li>' .Connect::widget([ 'baseAuthUrl' => ['/user/security/auth']]). '</li>') : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->profile->name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )

        ],

    ]);
    NavBar::end();
    ?>



    <div class="container">


            <div class="row">
            <div class="col-lg-12">
                <div class="input-group">
                    <form method="get" action="<?=\yii\helpers\Url::to(['category/search']) ?>">
                    <input type="text" class="form-control" name="params" placeholder="Введіть дані для пошуку">
                    </form>
                    <span class="input-group-btn">
        <button class="btn btn-default" type="button">Шукати</button>
      </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div>


        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<a href="#" id="up_page"></a>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
