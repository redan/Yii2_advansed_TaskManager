<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\tables\Users;
use common\models\tables\TaskStatuses;

/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'creator_id')->dropDownList(Users::getUsersList()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->widget(\yii\jui\DatePicker::className(),[
        'dateFormat' => 'yyyy/MM/dd',
    ]) ?>

    <?= $form->field($model, 'responsible_id')->dropDownList(Users::getUsersList()) ?>

    <?= $form->field($model, 'status_id')->dropDownList(TaskStatuses::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
