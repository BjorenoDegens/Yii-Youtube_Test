<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\Users;
use app\models\Video;
use app\models\VideoLike;
use app\models\VideoView;
use Yii;
use yii\data\ActiveDataProvider;
use yii\debug\panels\EventPanel;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use function PHPUnit\Framework\returnValueMap;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout','like','dislike','signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['logout','like','dislike'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['signup'],
                        'roles' => ['?']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new  ActiveDataProvider([
            'query' => Video::find()->published()
        ]);
        $users = Users::find()
            ->where(["FacebookLike" => 1])
            ->all();
        return $this->render('index', [
            'users' => $users,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function __toString()
    {
        return $this->render;
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model =  new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup())
        {
            return $this->redirect(Yii::$app->homeUrl);
        }

        return $this->render('signup',[
            'model'=> $model
            ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionYoutube()
    {
        $this->layout = 'auth';
        return $this->render('youtube');
    }

    public function actionView($id)
    {
        $video = $this->findVideo($id);

        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        $similarVideos = Video::find()->published()
            ->byKeyword($video->title)
            ->andWhere(['NOT', ['video_id' => $id]])
            ->limit(10)->all();

        return $this->render('view',[
            'model' => $video,
            'similarVideos' => $similarVideos
        ]);
    }

    public function actionLike($id)
    {
        $video = $this->findVideo($id);
        $userID = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($userID,$id)
            ->one();
        if (!$videoLikeDislike)
        {
            $this->saveLikeDislike($id,$userID,VideoLike::TYPE_LIKE);
        }else if ($videoLikeDislike->type === VideoLike::TYPE_LIKE)
        {
            $videoLikeDislike->delete();
        }else
        {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($id,$userID,VideoLike::TYPE_LIKE);

        }
        return $this->renderAjax('_buttons',[
            'model' => $video
        ]);
    }

    public function actionSearch($keyword)
    {
        $dataProvider = new  ActiveDataProvider([
            'query' => Video::find()->published()->latest()->byKeyword($keyword)
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDislike($id)
    {
        $video = $this->findVideo($id);
        $userID = \Yii::$app->user->id;

        $videoLikeDislike = VideoLike::find()
            ->userIdVideoId($userID,$id)
            ->one();
        if (!$videoLikeDislike)
        {
            $this->saveLikeDislike($id,$userID,VideoLike::TYPE_DISLIKE);
        }else if ($videoLikeDislike->type === VideoLike::TYPE_DISLIKE)
        {
            $videoLikeDislike->delete();
        }else
        {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($id,$userID,VideoLike::TYPE_DISLIKE);

        }
        return $this->renderAjax('_buttons',[
            'model' => $video
        ]);
    }


    protected function findVideo($id)
    {
        $video = Video::findOne($id);
        if(!$video){
            throw new NotFoundHttpException('Video does not exist');
        }
        return $video;
    }

    protected function saveLikeDislike($videoID, $userID,$type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $videoID;
        $videoLikeDislike->user_id = $userID;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }
}