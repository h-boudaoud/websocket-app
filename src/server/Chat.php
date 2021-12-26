<?php

namespace App\Server;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface {

    protected $clients;
    private $users = [];
    private $lastMessages=[];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $msg =["content"=>"Connection established"];
        $conn->send(json_encode($msg));

        echo "New connection! ({$conn->resourceId})\n";
        //var_dump($msg);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo $msg."\n";
        $msg =json_decode($msg);
        if(!empty($msg->from)) {
            $msg = ["from" => $msg->from, "content" => $msg->content];
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    $client->send(json_encode($msg));
                }
            }
        }else{
//            $msg =["content"=>"Your name is not defined"];
//            $from->send(json_encode($msg));
        }
    }

    public function onClose(ConnectionInterface $conn) {

    }

    public function onError(ConnectionInterface $conn, \Exception $e) {

    }

}