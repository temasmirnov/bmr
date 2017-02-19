<?php

namespace app\controllers;

use Yii;
use app\models\Trainer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

require_once Yii::$app->basePath . "/helpers/CImage.php";

/**
 * TrainerController implements the CRUD actions for Trainer model.
 */
class TrainerController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Trainer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Trainer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trainer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Trainer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Trainer();
        
        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->photo = UploadedFile::getInstanceByName('Trainer[photo]');
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->trainer_id]);
            }
        }
         
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Trainer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->request->isPost) {
            $old_name = $model->photo;
            
            $model->load(Yii::$app->request->post());
            $model->photo = UploadedFile::getInstance($model, "photo");
            
            if(!$model->photo) {
                $model->photo = $old_name;
            }
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->trainer_id]);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Trainer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Trainer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trainer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trainer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
