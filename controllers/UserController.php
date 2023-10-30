<?php

namespace app\controllers;


use app\models\RegisterForm;
use app\models\SigninForm;
use yii\base\Model;
use yii\db\Exception;
use yii\debug\panels\EventPanel;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSignup(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;


        try {
            $model = new RegisterForm();

            if($model->load($request->post(),'')){
                \Yii::$app->response->setStatusCode(201);

                $user = $model->register();

                return ['success' => true, 'message' => 'User registered successfully','user'=>$user];
            }
        }
        catch (\Exception $ex){
            \Yii::$app->response->setStatusCode(400);
            return ['success' => false, 'message' => $ex->getMessage()];
        }


    }

    public function actionSignin(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            $model = new SigninForm();

            if ($model->load($request->post(),'')){


                $user = $model->signIn();
                if($user !== false){
                    \Yii::$app->response->setStatusCode(200);
                    return ['success' => true, 'message' => 'User SignIn successfully', 'user'=> $user];
                }
                else{
                    \Yii::$app->response->setStatusCode(401);
                    return ['success' => false, 'message' => 'Password is not correct'];
                }


            }
        }
        catch (\Exception $ex){
            echo $ex->getMessage();
        }
    }

}