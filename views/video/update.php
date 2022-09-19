<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Video $model */

$this->title = 'Update Video: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'MyVideos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
