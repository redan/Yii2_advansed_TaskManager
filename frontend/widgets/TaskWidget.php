<?php

namespace app\widgets;


use common\models\tables\Tasks;
use yii\base\Exception;
use yii\base\Widget;

class TaskWidget extends Widget
{
    public $model;
    public $attributes;

    public function run()
    {
        if(is_a($this->model, Tasks::class)){
            return $this->render('taskView', ['model' => $this->model]);
        }
        throw new \Exception('Error');
    }
}