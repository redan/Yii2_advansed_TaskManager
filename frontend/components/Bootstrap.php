<?php

namespace frontend\components;


use common\models\tables\Tasks;
use yii\base\Component;
use yii\base\Event;

class Bootstrap extends Component
{
    public function init()
    {
        $this->attachEventHandlers();
        $this->languageSet();
    }

    public function languageSet()
    {
        if($lang = \Yii::$app->session->get('lang')){
            \Yii::$app->language = $lang;
        }
    }

    protected function attachEventHandlers(){
        Event::on(Tasks::class, Tasks::EVENT_AFTER_INSERT, function ($event){

            $task = $event->sender;
            $user = $task->responsible;

            \Yii::$app->mailer->compose()
                ->setTo($user->email)
                ->setFrom('test@test.ru')
                ->setSubject('Создана новая задача')
                ->setTextBody("У вас появилась задача {$task->name}")
                ->send();
        });
    }
}