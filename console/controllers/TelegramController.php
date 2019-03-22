<?php

namespace console\controllers;

use common\models\tables\TelegramOffset;
use SonkoDmitry\Yii\TelegramBot\Component;
use yii\console\Controller;

class TelegramController extends Controller
{
    /** @var  Component */
    private $bot;
    private $offset = 0;

    /**
     * TelegramController constructor.
     */
    public function init()
    {
        parent::init();
        $this->bot = \Yii::$app->bot;
        $this->bot->setProxy('socks5://98.172.253.157');
    }

    public function actionIndex()
    {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if ($updCount > 0) {
            echo "Новых сообщений: " . $updCount . PHP_EOL;
            foreach ($updates as $update) {
                $message = $update->getMessage();
                if ($this->processCommand(
                    (string)$message->getText(),
                    $message->getFrom()->getId()
                )
                ) {

                    $this->updateOffset($update->getUpdateId());
                }
            }
        } else {
            echo "Новых сообщений нет" . PHP_EOL;
        }
    }

    /**
     * @return int|mixed
     */
    private function getOffset()
    {
        $max = TelegramOffset::find()
            ->select("id")
            ->max('id');
        if ($max > 0) {
            $this->offset = $max;
        }
        return $this->offset;
    }

    /**
     * @param int $id
     */
    private function updateOffset(int $id)
    {
        (new TelegramOffset([
            'id' => $id,
            'timestamp' => date("Y-m-d h:i:s")
        ]))->save();
    }


    private function processCommand(string $message, int $fromId)
    {
        //"/command Param1 Param2 Param3"
        $params = explode(" ", $message);
        $command = $params[0];
        unset($params[0]);
        $response = "Unknown command";
        switch ($command) {
            case '/help':
                $response = "Доступные команды: \n";
                $response .= "/help - список комманд\n";
                $response .= "/project_create ##project_name## -создание нового проекта\n";
                $response .= "/task_create ##task_name## ##responcible## ##project## -созданпие таска\n";
                $response .= "/sp_create  - подписка на создание проекты\n";
                break;
            case "/sp_create":

                break;
        }

        $this->bot->sendMessage($fromId, $response);
        return true;
    }
}