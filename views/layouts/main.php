<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use dektrium\user\widgets\Connect;
use app\models\History;

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
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    $session = Yii::$app->session;
    $qty_head = $session['cart.qty'];
    $qty_head = !$qty_head ? 0 : $qty_head;
    NavBar::begin([
        'brandLabel' => 'SoftBistro Food',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => $qty_head . ' шт.', 'url' => ['/cart/index'], 'options' => ['class' => 'cart_navbar']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = '<li>' .Connect::widget([ 'baseAuthUrl' => ['/user/security/auth']]). '</li>';
    } else {

        $subitems = [];
        if(Yii::$app->user->identity->isAdmin)
        {
            $subitems[] = [
                'label' => 'Користувачі',
                'url' => ['/user/admin/index'],
            ];

            $subitems[] = [
                'label' => 'Замовлення',
                'url' => ['/user/admin/orders'],
            ];

            $subitems[] = [
                'label' => 'Менеджер',
                'url' => ['/a-category/index'],
            ];

            $subitems[] = [
                'label' => 'Мій кабінет',
                'url' => ['/user/settings'],
            ];

            $subitems[] = [
                'label' => 'Вихід',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ];

        } else
        {
            $subitems[] = [
                'label' => 'Мій кабінет',
                'url' => ['/user/settings'],
            ];

            $subitems[] = [
                'label' => 'Вихід',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ];

        }

        $menuItems[] = ['label' => Yii::$app->user->identity->profile->name,
            'items' => $subitems,
        ];

    }
    echo Nav::widget([
        'options' => ['class' =>'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();

    ?>


    <div class="container main_container">
    <!--<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form method="get" action=" class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Введіть дані для пошуку">
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Шукати">
                    </span>
                </form>
            </div>
        </div> -->

        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Головна ', 'url' => '/'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<a href="#" id="up_page"></a>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; SoftBistro Food <?= date('Y') ?></p>

        <p class="pull-right"><?= date("d.m.Y") . 'р.' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
