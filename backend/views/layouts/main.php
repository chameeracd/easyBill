<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

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
    <script type="text/javascript">
        $('.nav li a[href$="' + $(location).attr('pathname') + '"]').parents('li.dropdown').addClass('active');
    </script>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Central Beach',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
            } else {
                $menuItems[] = ['label' => 'Home', 'url' => ['/site/index']];
                $adminSubMenu[] = ['label' => 'Settings', 'url' => ['/setting/index']];
                $adminSubMenu[] = ['label' => 'Category', 'url' => ['/category/index']];
                $adminSubMenu[] = ['label' => 'Item', 'url' => ['/item/index']];
                $adminSubMenu[] = ['label' => 'User', 'url' => ['/user/admin/index']];
                $adminSubMenu[] = ['label' => 'Audit', 'url' => ['/audit']];
                $menuItems[] = ['label' => 'Admin', 'items' => $adminSubMenu];
                
                $userSubMenu[] = ['label' => 'Profile', 'url' => ['/user/settings/profile']];
                $userSubMenu[] = [
                    'label' => 'Logout',
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
                $menuItems[] = ['label' => "Hello " . Yii::$app->user->identity->username . "!", 'items' => $userSubMenu];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= date('Y') ?> Central Beach Inn - Mirissa</p>
            <p class="pull-right"><?= 'Powered by <a href="http://www.facebook.com/chameeracd" rel="external">Chameera</a>' ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
