<?php

namespace app\controllers;

use app\models\City;
use app\models\User;
use Yii;
use app\models\Review;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        if ($id) {
            $authorsReviews = true;
            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Review::find()->where(['id_author' => $id]),
                ]
            );
        } else {
            $authorsReviews = false;
            if (!Yii::$app->session->has('city')) {
                return Yii::$app->runAction('site/index');
            }
            $city = Yii::$app->session->get('city');
            $cityId = City::findOne(['name' => $city]);

            $dataProvider = new ActiveDataProvider(
                [
                    'query' => Review::find()->where(['id_city' => $cityId])->orWhere(['id_city' => null]),
                ]
            );
        }


        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'authorsReviews' => $authorsReviews
            ]
        );
    }

    /**
     * Displays a single Review model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    /**
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Review();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Отзыв успешно создан');
            $this->save($model);
            return $this->renderAjax(
                'create',
                [
                    'model' => $model,
                ]
            );
        }
        else {
            return $this->render(
                'create',
                [
                    'model' => $model,
                ]
            );
        }

    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $this->save($model);
            Yii::$app->session->setFlash('success', 'Отзыв успешно отредактирован');
        }
        return $this->render(
            'update',
            [
                'model' => $model,
            ]
        );
    }

    public function save($model)
    {
        $cityName = Yii::$app->request->post('Review')['cityName'];
        $city = City::findOne(['name' => $cityName]);
        if ($city === null) {
            $city = new City();
            $city->name = $cityName;
            $city->save();
        }
        $model->id_city = $city->id;
        if ($model->img) {
            unlink('.' . $model->img);
        }
        $model->imgFile = UploadedFile::getInstance($model, 'imgFile');
        if ($model->imgFile) {
            $model->uploadImg();
        } else {
            $model->img = null;
        }
        $model->save();
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->renderAdmin();
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetAuthorData($id)
    {
        $data = User::find()
            ->select('fio, email, phone')
            ->where(['id' => $id])
            ->one();
        $response = [
            'email' => $data->email,
            'phone' => $data->phone,
            'fio' => $data->fio
        ];
        return Json::encode($response);
    }

    public function renderAdmin()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Review::find()->where(['id_author' => Yii::$app->user->id])
            ]
        );

        return $this->render(
            'admin',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionAdmin()
    {
        return $this->renderAdmin();
    }
}
