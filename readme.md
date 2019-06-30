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

## Celery Setup

#### Install pip3
```
sudo apt install python3-pip
```

#### Install the virtualenv package
The virtualenv package is required to create virtual environments. You can install it with pip:
```
sudo pip3 install virtualenv
```

#### Create the virtual environment
To create a virtual environment, you must specify a path. For example to create one in the local directory called ‘myvenv’, type the following:
```
virtualenv myvenv
```
#### Activate the virtual environment
You can activate the python environment by running the following command:
```
source myvenv/bin/activate
```

### Install Celery
```
pip3 install celery
```