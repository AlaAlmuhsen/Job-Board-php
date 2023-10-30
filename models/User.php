<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property int $type
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password','auth_key','type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['email', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth_key',
            'type' => 'Type',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'email',
            'auth_key',
            'type'
        ];
    }


    public function setPassword($password){
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }


    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }



    //static functions
    public static function findUserByEmail($email){
        return self::findOne(['email' => $email]);
    }

    public static function findUserByAuthKey($auth_key){
        return self::findOne(['auth_key' => $auth_key]);
    }
}
