<?php

namespace app\common\models\tables;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $chanel
 * @property string $message
 * @property int $user_id
 * @property string $created_at
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'chanel', 'message', 'user_id', 'created_at'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['chanel'], 'string', 'max' => 250],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chanel' => 'Chanel',
            'message' => 'Message',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
