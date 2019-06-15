<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once('../local/config.php');
try
{
    $connection = new AMQPConnection(
        $CONFIG['host'],    #host - host name where the RabbitMQ server is runing
        $CONFIG['port'],           #port - port number of the service, 5672 is the default
        $CONFIG['user'],        #user - username to connect to server
        $CONFIG['password']         #password
        );
}
catch(exception $e)
{
    print_r($e);
}
echo "Success!";
?>