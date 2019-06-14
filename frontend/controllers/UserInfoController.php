<?php

namespace frontend\controllers;

use Yii;
use common\models\UserInfo;
use common\models\UserInfoSearch;
use backend\controllers\UserInfoBaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class UserInfoController extends UserInfoBaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new UserInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        if (UserInfo::find()->where(['user_id' => Yii::$app->user->getId()])->one()) {
            return $this->setError('Sorry, your contact information already exists. You can update it.');
        }

        $model = new UserInfo();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->getId();
            $this->uploadImage($model);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->getId()) {
            return $this->setError('Sorry, you can only update your own contact information.');
        }

        $user_photo = $model->user_photo;
        if ($model->load(Yii::$app->request->post())) {
            $this->uploadImage($model);
            if (!$model->user_photo)
                $model->user_photo = $user_photo;
            else
                $this->deleteUserPhoto($user_photo);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id !== Yii::$app->user->getId()) {
            return $this->setError('Sorry, you can only delete your own contact information.');
        }
        $this->deleteUserPhoto($model->user_photo);
        $model->delete();

        return $this->redirect(['index']);
    }
}
