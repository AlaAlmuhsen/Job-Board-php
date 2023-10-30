<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use function PHPUnit\Framework\throwException;

class SigninForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return[
            [['email','password'],'required']
        ];
    }

    public function signIn(){
        if ($this->validate()){
            $user = User::findUserByEmail($this->email);
            if ($user && Yii::$app->getSecurity()->validatePassword($this->password, $user->password)){
                return $user;
            }
            else{
                return false;
            }
        }
    }
}