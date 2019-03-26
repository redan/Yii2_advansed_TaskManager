<?php
namespace api\modules\v1\controllers;

use common\models\tables\Tasks;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)){
                    return $user;
                }
            }
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        if($_GET['resp']){
            $query = Tasks::find()->where(['responsible_id' => $_GET['resp']]);
            return new ActiveDataProvider([
                'query' => $query
            ]);
        } else
        $query = Tasks::find();
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}