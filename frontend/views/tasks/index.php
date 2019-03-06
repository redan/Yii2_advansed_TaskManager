<?php

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;

$model = \frontend\models\tables\Tasks::find()->all();
?>
    <p>
        <?= \yii\helpers\Html::a('Create Tasks', ['admin-task/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="search_container">
        <?php
            $form = \yii\widgets\ActiveForm::begin([
                'action' => \yii\helpers\Url::to(['/tasks/index']),
                'method' => 'get',
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]);
            $items = [1 => 'Январь', 'Февраль', 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' ];
            $params = ['prompt' => 'Выберите месяц', 'options' => ['' => ['selected' => true]]];
            ?>

            <?= $form->field($searchModel, 'month')->dropDownList($items, $params); ?>
            <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-warning']) ?>

        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>

    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
                'tag' => 'div',
                'class' => 'tasks_container'
                ],
        'layout' => "{items}\n{pager}",
        'itemView' => function($model)
        {
            return \app\widgets\TaskWidget::widget(['model' => $model]);
        },
    ])?>