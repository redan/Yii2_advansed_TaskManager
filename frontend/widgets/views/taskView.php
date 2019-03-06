<?php
//$form = \yii\widgets\ActiveForm::begin();
//$form->field($model, 'id');
//\yii\widgets\ActiveForm::end();

use yii\helpers\Url;
//** @var $model \frontend\models\tables\Task */
?>

<div class="task-container">
    <a href="<?= Url::to(['tasks/one', 'id' => $model->id])?>">
        <div class="task">
            <div><?= $model->name ?></div>
            <div><?= $model->description ?></div>
            <div><?= $model->creator->username ?></div>
            <dev><?= $model->responsible->username ?></dev>
        </div>
    </a>
</div>