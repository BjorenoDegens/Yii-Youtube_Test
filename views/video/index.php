<?php

use app\models\Subscriber;
use app\models\Video;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var $latestVideo Video
 * @var $numberOfViews integer
 * @var $numberOfSubscribers integer
 * @var $subscribers Subscriber[]
 *
 **/
$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index d-flex flex-row">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card m-2" style="width: 18rem;">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
            <video style="width:285px; height:150px" poster="<?php echo $latestVideo->getThumbnailLink() ?>"
                   class="embed-responsive-item" src="<?php echo $latestVideo->getVideoLink() ?>"></video>
        </div>        <div class="card-body">
            <h6 class="card-title"><?php echo $latestVideo->title ?></h6>
            <p class="card-text">
                likes: <?php echo $latestVideo->getLikes()->count() ?>
                <br>
                views: <?php echo $latestVideo->getViews()->count() ?>
            </p>
            <a href="<?php echo Url::to(['/video/update', 'video_id' => $latestVideo->video_id]) ?>" class="btn btn-primary">Edit</a>
        </div>
    </div>
    <div class="card m-2" style="width: 18rem;">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
        </div>
        <div class="card-body">
            <h6 class="card-title">Total Views</h6>
            <p class="card-text" style="font-size: 48px">
               <?php echo $numberOfViews?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 18rem;">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
        </div>
        <div class="card-body">
            <h6 class="card-title">Total Subscribers</h6>
            <p class="card-text" style="font-size: 48px">
               <?php echo $numberOfSubscribers?>
            </p>
        </div>
    </div>    <div class="card m-2" style="width: 18rem;">
        <div class="embed-responsive embed-responsive-16by9 mb-3">
        </div>
        <div class="card-body">
            <h6 class="card-title">Latest Subscribers</h6>
            <p class="card-text">
               <?php foreach ($subscribers as $subscriber):?>
                <div>
                <?php echo $subscriber->user->username;?>
            </div>
               <?php endforeach; ?>
            </p>
        </div>
    </div>


</div>



<!--GridView::widget([-->
<!--    'dataProvider' => $dataProvider,-->
<!--    'columns' => [-->
<!--        ['class' => 'yii\grid\SerialColumn'],-->
<!---->
<!--        [-->
<!--            'attribute' =>'video_id',-->
<!--            'content' => function($model){-->
<!--                return $this->render('_video_item',['model' => $model]);-->
<!--            }-->
<!--        ],-->
<!--        [-->
<!--            'attribute' => 'status',-->
<!--            'content' => function($model){-->
<!--                return $model->getStatusLabels()[$model->status];-->
<!--            }-->
<!--        ],-->
<!--        //'has_thumbnail',-->
<!--        //'video_name',-->
<!--        'created_at:datetime',-->
<!--        'updated_at:datetime',-->
<!--        //'create_by',-->
<!--        [-->
<!--            'class' => ActionColumn::className(),-->
<!--            'urlCreator' => function ($action, Video $model, $key, $index, $column) {-->
<!--                return Url::toRoute([$action, 'video_id' => $model->video_id]);-->
<!--            }-->
<!--        ],-->
<!--    ],-->
<!--]); -->