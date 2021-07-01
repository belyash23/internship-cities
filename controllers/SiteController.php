<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
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
        return $this->render('index');
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
        return $this->render(
            'login',
            [
                'model' => $model,
            ]
        );
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
        return $this->render(
            'contact',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        if (!YII::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->fio = $model->fio;
            $user->email = $model->email;
            $user->phone = $model->phone;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->confirmation_token = Yii::$app->getSecurity()->generateRandomString();
            $user->save();
            Yii::$app->session->setFlash('success', 'Проверьте свою почту для подтверждения регистрации');
            self::sentEmailConfirmation($user);
            return $this->goHome();
        }

        return $this->render(
            'signup',
            [
                'model' => $model
            ]
        );
    }

    private static function sentEmailConfirmation($user)
    {
        $email = $user->email;

        Yii::$app->mailer
            ->compose(
                ['html' => 'confirm-email'],
                ['user' => $user]
            )
            ->setTo($email)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Confirmation of registration')
            ->send();
    }

    private static function confirmEmail($token, $email)
    {
        $user = User::findOne(['confirmation_token' => $token, 'email' => $email]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->confirmation_token = null;
        $user->status = User::STATUS_CONFIRMED;
        $user->save();
    }

    public function actionConfirmEmail($token, $email)
    {
        try {
            self::confirmEmail($token, $email);
            Yii::$app->session->setFlash('success', 'Вы успешно подтвердили свою почту.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->goHome();
    }

}
