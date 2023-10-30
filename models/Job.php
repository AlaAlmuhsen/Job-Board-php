<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $recruiter_id
 *
 * @property JobApplication[] $jobApplications
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'recruiter_id'], 'required'],
            [['recruiter_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'recruiter_id' => 'Recruiter ID',
        ];
    }

    public function getJobApplications(){
        return $this->hasMany(JobApplication::class, ['job_id' => 'id']);
    }
}
