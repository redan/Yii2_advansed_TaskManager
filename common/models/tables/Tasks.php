<?php

namespace common\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $creator_id
 * @property string $name
 * @property string $description
 * @property string $deadline
 * @property int $responsible_id
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TaskAttachments[] $taskAttachments
 * @property TaskComments[] $taskComments
 * @property TaskStatuses $status
 * @property Users $creator
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_id', 'responsible_id', 'status_id'], 'integer'],
            [['name', 'description', 'deadline'], 'required'],
            [['deadline'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskStatuses::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => Yii::t("app", 'Task_Creator_ID'),
            'name' => Yii::t("app", 'Task_Name'),
            'description' => Yii::t("app", 'Task_Description'),
            'deadline' => Yii::t("app", 'Task_Deadline'),
            'responsible_id' => Yii::t("app", 'Task_Responsible_ID'),
            'status_id' => Yii::t("app", 'Task_Status_ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(TaskStatuses::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Users::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        return $this->hasOne(Users::className(),['id' => 'responsible_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttachments()
    {
        return $this->hasMany(TaskAttachments::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskComments()
    {
        return $this->hasMany(TaskComments::className(), ['task_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
