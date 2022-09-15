
<header id="header">
    <?php

    use yii\bootstrap5\Html;
    use yii\bootstrap5\Nav;
    use yii\bootstrap5\NavBar;
?><div> <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'YoutubeInterface', 'url' => ['/video/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'CRUD', 'url' => ['/article/index']],
            ['label' => 'Signup', 'url' => ['/site/signup']],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ]
    ]);
    ?>
    </div>
    <div>
        <form action="<?php echo \yii\helpers\Url::to('/site/search') ?>" class="form-inline my-2 my-lg-0 d-flex flex-row">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" name="keyword"
            value="<?php echo Yii::$app->request->get('keyword') ?>">
            <button class="btn btn-outline-success my-2 my-sm-0">Search</button>
        </form>
    </div>
    <?php
    NavBar::end();
    ?>
</header>
