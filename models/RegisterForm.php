<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $type;

    public function rules()
    {
        return[
            [['name','email','password','type'],'required']
        ];
    }

    public function register()
    {

        if ($this->validate()){

            $user = new User();

            $user->name = $this->name;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->type = $this->type;

            if ($user->save()){
                return User::findUserByEmail($this->email);
            }
        }
        return [];
    }
}