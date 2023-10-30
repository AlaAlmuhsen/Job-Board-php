<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobApplication;
use app\models\User;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\Response;

class JobController extends Controller {

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreateJob(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authorized'];
        }
        elseif ($user->type !== 1){
            \Yii::$app->response->setStatusCode(403);
            return ['success' => false, 'message' => 'Job Creation Failed because Job Recruter Can\'t Apply For a Job '];
        }
        else {
            $model = new Job();
            if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post(), '')){
                $model->recruiter_id = $user->id;
                if ($model->validate() && $model->save()){
                    \Yii::$app->response->setStatusCode(201);
                    return ['success' => true, 'message' => 'Job created successfully', 'job' => $model];
                }
                else {
                    \Yii::$app->response->setStatusCode(404);
                    return ['success' => false, 'message' => 'Job creation failed', 'errors' => $model->getErrors()];
                }
            }
            else {
                \Yii::$app->response->setStatusCode(404);
                return ['success' => false, 'message' => 'Invalid job data'];
            }
        }
    }

    public function actionJobs(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authorized'];
        }
        else{
            $jobs = Job::find()->all();

            \Yii::$app->response->setStatusCode(200);
            return ['success' => true, 'jobs'=>$jobs];
        }
    }

    public function actionJob($jobId){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authorized'];
        }
        else{
            $job = Job::findOne(['id'=>$jobId]);

            if ($job === null){
                \Yii::$app->response->setStatusCode(200);
                return ['success' => false, 'message'=>'Job not found'];
            }
            \Yii::$app->response->setStatusCode(200);
            return ['success' => true, 'jobs'=>$job];
        }
    }

    public function actionJobApplicationApplied($jobId){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authenticated'];
        }
        elseif ($user->type !== 1){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'Seeker Can\'t see applications for this job'];
        }
        else{
            $job = Job::findOne($jobId);

            if (!$job){
                \Yii::$app->response->setStatusCode(404);
                return ['success' => false, 'message' => 'Job not found'];
            }
            if ($job->recruiter_id !== $user->id){
                \Yii::$app->response->setStatusCode(401);
                return ['success' => false, 'message' => 'User is not authorized'];
            }

            $jobApplications = $job->getJobApplications()
                ->asArray()
                ->all();

            return ['success' => true, 'job_seekers' => $jobApplications];
        }
    }

    public function actionApplyForJob($jobId){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authenticated'];
        }
        elseif ($user->type !== 2){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'Recruiter Can\'t Apply For A Job'];
        }
        else{
            $job = Job::findOne($jobId);
            if (!$job) {
                \Yii::$app->response->setStatusCode(404);
                return ['success' => false, 'message' => 'Job not found'];
            }

            $existingApplication = JobApplication::find()
                ->where(['job_id' => $jobId, 'seeker_id' => $user->id])
                ->one();

            if ($existingApplication) {
                return ['success' => false, 'message' => 'You have already applied for this job'];
            }

            $jobApplication = new JobApplication();
            $jobApplication->job_id = $jobId;
            $jobApplication->seeker_id =$user->id;

            if ($jobApplication->save()) {
                \Yii::$app->response->setStatusCode(201);
                return ['success' => true, 'message' => 'Job application submitted successfully'];
            } else {
                $errors = $jobApplication->getErrors();
                return ['success' => false, 'message' => 'Job application failed', 'error'=>$errors];
            }
        }
    }

    public function actionUserApplications(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $headers = $request->getHeaders()->toArray();
        $auth_key = explode(' ', $headers['authorization'][0])[1];

        $user = User::findUserByAuthKey($auth_key);

        if ($user === null ){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'User is not authenticated'];
        }
        elseif ($user->type !== 2){
            \Yii::$app->response->setStatusCode(401);
            return ['success' => false, 'message' => 'Recruiter Can\'t Apply For A Job'];
        }
        else{
            $userApplications = JobApplication::find()->where(['seeker_id' => $user->id])->all();

            if ($userApplications === null){
                \Yii::$app->response->setStatusCode(404);
                return ['success' => false, 'message' => 'User not applied for any job yet'];
            }

            \Yii::$app->response->setStatusCode(404);
            return ['success' => true, 'applications'=>$userApplications];

        }
    }
}