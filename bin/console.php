<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/server/Chat.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Server\Chat;

const PORT = 3001;
$server = IoServer::factory(

    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    PORT
);

echo "open webSocketApp server  on : http://127.0.0.1:" . PORT . "\n\r";
$server->run();
