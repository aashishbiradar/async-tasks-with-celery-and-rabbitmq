#Asynchronous Processing with RabbitMQ and Celery

When building web applications, you will inevitably find certain actions that are taking too long and as a result must be pulled out of the http response cycle. These actions can be performed asynchronously with celery.

##RabbitMQ Setup

Install RabbitMQ

```
sudo apt-get install rabbitmq-server
```

Restart RabbitMQ

```
service rabbitmq-server restart
```