<?php

namespace frontend\controllers;

use SonkoDmitry\Yii\TelegramBot\Component;
use yii\web\Controller;

class TelegramController extends Controller
{
    /**
     * @return string
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function actionIndex()
    {

        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        //$bot->setProxy('socks5://145.239.81.69:1080');
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);

        $updates = $bot->getUpdates();
        $messages = [];

        foreach ($updates as $update) {
            $message = $update->getMessage();
            $from = $message->getFrom();
            $username = $from->getFirstName() . " " . $from->getLastName();
            $messages[] = [
                'text' => $message->getText(),
                'username' => $username
            ];
        }

        return $this->render('receive', ['messages' => $messages]);
    }

    /**
     * @param $userID
     * @param $text
     * @throws \TelegramBot\Api\Exception
     * @throws \TelegramBot\Api\InvalidArgumentException
     */
    public function actionSend($userID, $text)
    {
        /** @var Component $bot */
        $bot = \Yii::$app->bot;
        $bot->sendMessage($userID, $text);
    }
}