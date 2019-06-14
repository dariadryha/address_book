<?php

namespace common\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "user_info".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $address
 * @property string $user_photo
 *
 * @property User $user
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name', 'last_name', 'phone_number', 'address'], 'required'],
            [['user_photo'], 'required', 'message' => 'Photo can\'t be blank', 'on' => 'create'],
            ['user_photo', 'file', 'extensions' => ['png', 'jpg'], 'wrongExtension' => 'Only {extensions} types are allowed for photo.'],
            [['user_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['phone_number', 'address', 'user_photo'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'user_photo' => 'User Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
