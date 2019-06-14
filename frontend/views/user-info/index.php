<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Address Book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add user info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
        'rowOptions' => [
            'class' => 'text-center'
        ],
        'pager' => [
            'options' => ['class' => 'pagination'],
            'prevPageLabel' => 'Previous',
            'nextPageLabel' => 'Next',
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'nextPageCssClass' => 'next',
            'prevPageCssClass' => 'prev',
            'firstPageCssClass' => 'first',
            'lastPageCssClass' =>' last',
            'maxButtonCount' => 3,
        ],
        'columns' => [
            'fullName',
            //'first_name',
            //'last_name',
            [
                'attribute' => 'user',
                'value' => 'user.email',
                'label' => 'Email',
            ],
            // /'email',
            'phone_number',
            'address',
            [
                'attribute' => 'user_photo',
                'value' => function($data){
                    return Yii::getAlias('@userImgUrl') . '/' . $data->user_photo;
                },
                'format' => ['image', ['width' => 100, 'height' => 100]]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
        ],
    ]); ?>


</div>
