<?php


namespace console\controllers;


use common\models\tables\Tasks;
use yii\console\Controller;
use yii\console\ExitCode;

class MailController extends Controller
{
    public function actionMailDead()
    {
        /** @var Tasks $model */
        $model = Tasks::find()
            ->where(['DATEDIFF(now(), tasks.deadline) <= 1'])
            ->with('responsible')
            ->all();
        foreach ($model as $value){
            \Yii::$app->mailer->compose()
                ->setTo($value->responsible)
                ->setFrom('test@test.ru')
                ->setSubject('Сроки вашей задачи!')
                ->setTextBody("Ваша задача скоро должна быть завершена {$value->name}")
                ->send();
        }
    }
}