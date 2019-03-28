<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\tables\Users;
use common\models\tables\TaskStatuses;


/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-create">


    <div class="tasks-form">

        <?php $form = ActiveForm::begin(['action' => Url::to(['tasks/save-new'])]);?>

        <?= $form->field($model, 'creator_id')->dropDownList(Users::getUsersList()) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'deadline')->widget(\kartik\date\DatePicker::className(),[
            'pluginOptions' => [
                'format' => 'yyyy/mm/dd',
                'todayHighlight' => true
            ],
            'language' => 'ru'
        ]) ?>

        <?= $form->field($model, 'responsible_id')->dropDownList(Users::getUsersList()) ?>

        <?= $form->field($model, 'status_id')->dropDownList(TaskStatuses::getStatuses()) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
