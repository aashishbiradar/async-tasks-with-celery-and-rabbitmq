<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../local/config.php');
try
{
    $connection = new AMQPConnection(
        $CONFIG['host'],    #host - host name where the RabbitMQ server is runing
        5672,           #port - port number of the service, 5672 is the default
        'guest',        #user - username to connect to server
        'guest'         #password
        );
}
catch(exception $e)
{
    print_r($e);
}
echo "Success!";
?>