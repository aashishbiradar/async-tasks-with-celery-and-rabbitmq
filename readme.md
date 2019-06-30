# Asynchronous Processing with RabbitMQ and Celery

When building web applications, you will inevitably find certain actions that are taking too long and as a result must be pulled out of the http response cycle. These actions can be performed asynchronously with celery.

## RabbitMQ Setup and Configuration

Install RabbitMQ
```
sudo apt-get install rabbitmq-server
```

Restart RabbitMQ
```
sudo service rabbitmq-server restart
```

Check status
```
sudo rabbitmqctl status
```

Add vhost
```
sudo rabbitmqctl add_vhost 'myvhost'
```

Add user
```
sudo rabbitmqctl add_user 'username' 'password'
```

Set permissions
```
sudo rabbitmqctl set_permissions -p myvhost username ".*" ".*" ".*"
```

Set Administrator
```
sudo rabbitmqctl set_user_tags username adminstrator
```
