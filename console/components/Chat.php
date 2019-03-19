<?php

namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\WebSocket\WsConnection;

class Chat implements  MessageComponentInterface
{
    /** @var  WsConnection[]*/
    private $clients = [];

    /**
     * Chat constructor.
     */
    public function __construct()
    {
        echo "server started\n";
    }

    /**
     * @param WsConnection $conn
     */
    function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        $channel = explode("=", $queryString)[1];
        $this->clients[$channel][$conn->resourceId] = $conn;
        echo "New connection : {$conn->resourceId}\n";
    }

    /**
     * @param WsConnection $conn
     */
    function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
    }

    /**
     * @param WsConnection $conn
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo $e->getMessage() . PHP_EOL;
        $conn->close();
        unset($this->clients[$conn->resourceId]);
    }

    /**
     * @param WsConnection $from
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        echo "{$from->resourceId}: {$msg}\n";
        $data = json_decode($msg, true);
        try{
            (new \common\models\tables\Chat($data))->save();
        } catch (\Exception $e){
            var_dump($e->getMessage());
        }
        foreach ($this->clients[$data['channel']] as $client){
            $client->send($data['message']);
        }
    }

}