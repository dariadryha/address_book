<?php

use yii\db\Migration;
use common\models\User;
/**
 * Class m190614_095430_insert_user
 */
class m190614_095430_insert_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => '123456',
        ];
        $user = new User();
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->setPassword($data['password']);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        $connection = Yii::$app->db;
        Yii::$app
            ->db
            ->createCommand("UPDATE user SET role=". User::ROLE_ADMIN . " WHERE username='admin'")
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190614_095430_insert_user cannot be reverted.\n";

        return false;
    }
    */
}
