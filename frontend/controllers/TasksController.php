<?php

namespace frontend\controllers;


use common\models\filters\TasksSearch;
use frontend\models\forms\TaskAttachmentsAddForm;
use common\models\tables\TaskComments;
use common\models\tables\Tasks;
use common\models\tables\TaskStatuses;
use common\models\tables\Users;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class TasksController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['one'],
                'rules' => [
                    [
                        'actions' => ['one'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['search'],
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'SELECT COUNT(*) FROM post',
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOne($id)
    {
        $model = Tasks::findOne($id);
        $usersList = Users::getUsersList();
        $taskStatuses = TaskStatuses::getStatuses();

        return $this->render('one', [
            'model' => $model,
            'usersList' => $usersList,
            'taskStatuses' => $taskStatuses,
            'userId' => \Yii::$app->user->id,
            'taskCommentForm' => new TaskComments(),
            'taskAttachmentForm' => new TaskAttachmentsAddForm(),
            'channel' => 'Task_' . $id,
        ]);
    }

    public function actionSave($id)
    {
        if($model = Tasks::findOne($id)){
            $model->load(\Yii::$app->request->post());
            $model->save();
            \Yii::$app->session->setFlash('success', "Изменеия сохранены");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось сохранить изменения");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }



    public function actionAddComment()
    {
        $model = new TaskComments();
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            $id = $model->task_id;
//            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
            return $this->renderAjax('_comments', [
                'model' => Tasks::findOne($id),
                'taskCommentForm' => new TaskComments(),
                'userId' => \Yii::$app->user->id
            ]);
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить комментарий");
        }
    }

    public function actionAddAttachment()
    {
        $model = new TaskAttachmentsAddForm();
        $model->load(\Yii::$app->request->post());
        $model->file = UploadedFile::getInstance($model, 'file');
        if($model->save()){
            \Yii::$app->session->setFlash('success', "Файл добавлен");
        }else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить файл");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelete($id)

    {
        if($model = Tasks::findOne($id)) {
            $model->delete();
        }
        return $this->redirect(['tasks/index']);
    }

    public function actionCreate()
    {
        $model = new Tasks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSaveNew()
    {
        return $this->redirect(['tasks/index']);
    }
}