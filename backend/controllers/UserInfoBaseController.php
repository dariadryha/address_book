<?php

namespace backend\controllers;

use Yii;
use common\models\UserInfo;
use common\models\UserInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
abstract class UserInfoBaseController extends Controller
{
    /**
     * Lists all UserInfo models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new UserInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserInfo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    abstract public function actionCreate();

    /**
     * Updates an existing UserInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   abstract public function actionUpdate($id);

    /**
     * Deletes an existing UserInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    abstract public function actionDelete($id);

    /**
     * Finds the UserInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserInfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function uploadImage(&$model)
    {
        $model->save();
        $img = UploadedFile::getInstance($model, 'user_photo');
        if (!$img)
            return ;
        $imgName = 'user_' .  $model->user_id . '.' . $img->getExtension();
        $img->saveAs(Yii::getAlias('@userImgPath') . '/' . $imgName);
        $model->user_photo = $imgName;
    }

    public function setError($error_message)
    {
        Yii::$app->getSession()->setFlash('error', $error_message);
        return $this->redirect(['user-info/index']);
    }

    public function deleteUserPhoto($user_photo) {
        unlink(Yii::getAlias('@userImgPath') . '/' . $user_photo);
    }
}
