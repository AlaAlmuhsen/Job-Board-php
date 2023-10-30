<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_application".
 *
 * @property int $id
 * @property int $job_id
 * @property int $seeker_id
 * @property string $created_at
 *
 * @property Job $job
 * @property User $seeker
 */
class JobApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'seeker_id'], 'required'],
            [['job_id', 'seeker_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'seeker_id' => 'Seeker ID',
            'created_at' => 'Created At',
        ];
    }
}
