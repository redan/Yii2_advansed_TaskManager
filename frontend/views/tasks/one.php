<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\tables\Tasks */
/* @var $userList frontend\models\tables\Users[]*/
/**@var \frontend\models\tables\TaskComments $taskCommentForm */
/**@var \frontend\models\tables\TaskAttachments $taskAttachmentForm */


$this->title = Yii::t('app', 'Task_change') . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => \yii\helpers\Url::to(['admin-task/view', 'id' => $model->id])];
$this->params['breadcrumbs'][] = Yii::t('app', 'Task_change');
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['action' => Url::to(['tasks/save', 'id' => $model->id])]);?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-lg-3">
            <?= $form->field($model, 'creator_id')->dropDownList($usersList) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'status_id')->dropDownList($taskStatuses) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'responsible_id')->dropDownList($usersList) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'deadline')->widget(\kartik\date\DatePicker::className(),[
                'pluginOptions' => [
                    'format' => 'yyyy/mm/dd',
                    'todayHighlight' => true
                ],
                'language' => 'ru'
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
<div class="form-group">
    <? if(Yii::$app->user->can('TaskDelete')):?>
    <?php $form = ActiveForm::begin([
            'action' => Url::to(['tasks/delete', 'id' => $model->id])
    ]) ?>
        <div class="form-group">
            <?= Html::submitButton('Delete', ['class' => 'btn btn-danger']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <? endif;?>
</div>
<div class="attachments">
    <h3>Вложения</h3>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['tasks/add-attachment']),
        'options' => ['class' => "form-inline"]
    ]);?>
    <?=$form->field($taskAttachmentForm, 'taskId')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskAttachmentForm, 'file')->fileInput();?>
    <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
    <?ActiveForm::end()?>
    <hr>
    <div class="attachments-history">
        <?foreach ($model->taskAttachments as $file): ?>
            <a href="/img/tasks/<?=$file->path?>">
                <img src="/img/tasks/small/<?=$file->path?>" alt="">
            </a>
        <?php endforeach;?>
    </div>
    <div class="task-history">
        <div class="comments">
            <h3>Комментарии</h3>
            <?php $form = ActiveForm::begin(['action' => Url::to(['tasks/add-comment'])]);?>
            <?=$form->field($taskCommentForm, 'user_id')->hiddenInput(['value' => $userId])->label(false);?>
            <?=$form->field($taskCommentForm, 'task_id')->hiddenInput(['value' => $model->id])->label(false);?>
            <?=$form->field($taskCommentForm, 'content')->textInput();?>
            <?=Html::submitButton("Добавить",['class' => 'btn btn-default']);?>
            <?ActiveForm::end()?>
            <hr>
            <div class="comment-history">
                <?foreach ($model->taskComments as $comment): ?>
                    <p><strong><?=$comment->user->username?></strong>: <?=$comment->content?></p>
                <?php endforeach;?>
            </div>
        </div>

    </div>
</div>