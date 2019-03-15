<?php
namespace console\controllers;


use console\components\Chat;
use yii\console\Controller;

class WsController extends Controller
{
    public function actionIndex()
    {
        $server = \Ratchet\Server\IoServer::factory(
            new \Ratchet\Http\HttpServer(
                new \Ratchet\WebSocket\WsServer(
                    new Chat()
                )
            ), 8080
        );

        $server->run();
    }
}