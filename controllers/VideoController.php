<?php

namespace app\controllers;

use app\models\Subscriber;
use app\models\Video;
use app\models\VideoView;
use Yii;
use yii\data\ActiveDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
          return  [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['history'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ]
                        ]
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ]
          ];
    }

    /**
     * Lists all Video models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this ->layout = 'auth';
        $user = Yii::$app->user->identity;
        $userID = $user->id;
        $latestVideo = Video::find()
            ->latest()
            ->creator($userID)
            ->one();
        $numberOfViews = VideoView::find()
            ->alias('vv')
            ->innerJoin(Video::tableName() . 'v',
            'v.video_id = vv.video_id')
            ->andWhere(['v.created_by' => $userID])
            ->count();
        $numberOfSubscribers = $user
            ->getSubscribers()
            ->count();
        $subscribers = Subscriber::find()
            ->with('user')
            ->andWhere([
                'channel_id' => $userID
            ])
            ->orderBy('created_at DESC' )
        ->limit(3)->all();

        return $this->render('index',[
        'latestVideo' => $latestVideo,
        'numberOfViews' => $numberOfViews,
        'numberOfSubscribers' => $numberOfSubscribers,
        'subscribers' => $subscribers,
            ]);
    }

    public function actionMyvideos()
    {
        $this->layout = 'auth';
        $user = Yii::$app->user->identity;
        $userID = $user->id;
        $getMyVideos = Video::find()
            ->creator($userID)
            ->one();
        return $this->render('myvideos',[
            'getMyVideos' => $getMyVideos
        ]);

    }

    /**
     * Displays a single Video model.
     * @param string $video_id Video ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($video_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($video_id),
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this ->layout = 'auth';
        $model = new Video();
        $model->video = UploadedFile::getInstanceByName('video');
        if (Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['update', 'video_id' => $model->video_id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $video_id Video ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($video_id)
    {
        $model = $this->findModel($video_id);
        $model->thumbnail = UploadedFile::getInstanceByName('thumbnail');
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['update', 'video_id' => $model->video_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $video_id Video ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($video_id)
    {
        $this->findModel($video_id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionHistory(){
        $this->layout = 'auth';
        $query = Video::find()
            ->alias('v')
            ->innerJoin("(SELECT video_id, MAX(created_at) as max_date FROM video_view
            WHERE user_id = :userID
            GROUP BY video_id) vv",'vv.video_id = v.video_id',['userID' => Yii::$app->user->id])
            ->orderBy("vv.max_date DESC");

        $dataProvider = new  ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $video_id Video ID
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($video_id)
    {
        if (($model = Video::findOne(['video_id' => $video_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
