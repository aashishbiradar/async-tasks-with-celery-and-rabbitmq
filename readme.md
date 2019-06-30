# Asynchronous Processing with RabbitMQ and Celery

When building web applications, you will inevitably find certain actions that are taking too long and as a result must be pulled out of the http response cycle. These actions can be performed asynchronously with celery.

## RabbitMQ Setup and Configuration

#### Install RabbitMQ
```
$ sudo apt-get install rabbitmq-server
```

#### Restart RabbitMQ
```
$ sudo service rabbitmq-server restart
```

#### Check status
```
$ sudo rabbitmqctl status
```

#### Add vhost
```
$ sudo rabbitmqctl add_vhost 'myvhost'
```

#### Add user
```
$ sudo rabbitmqctl add_user 'username' 'password'
```

#### Set permissions
```
$ sudo rabbitmqctl set_permissions -p myvhost username ".*" ".*" ".*"
```

#### Set Administrator
```
$ sudo rabbitmqctl set_user_tags username adminstrator
```
#### Enable Management Plugin
```
$ sudo rabbitmq-plugins enable rabbitmq_management
```


## Celery Setup

#### Install pip3
```
$ sudo apt install python3-pip
```

#### Install the virtualenv package
The virtualenv package is required to create virtual environments. You can install it with pip:
```
$ sudo pip3 install virtualenv
```

#### Create the virtual environment
To create a virtual environment, you must specify a path. For example to create one in the local directory called ‘myvenv’, type the following:
```
$ virtualenv myvenv
```
#### Activate and Deactivate the virtual environment
You can activate the python environment by running the following command:
```
$ source myvenv/bin/activate
```

To decativate the virtual environment and use your original Python environment, simply type ‘deactivate’.
```
$ deactivate
```

#### Install Celery
```
$ pip3 install celery
```

#### Install Celery Flower
Flower is a web based tool for monitoring and administrating Celery clusters.
```
$ pip3 install flower
```

Launch the server and open http://localhost:5555:
```
$ flower --port=5555
```
#### Run celery worker
```
$ celery -A tasks worker --loglevel=info
```

## Keep Celery running with Supervisor
```
$ pip install supervisor
$ cd /path/to/your/project
$ echo_supervisord_conf > supervisord.conf
```
Next, just add this section after the [supervisord] section:
```
[program:celeryd]
command=/home/aashish/virtualenvs/yourvenv/bin/celery worker --app=tasks -l info 
stdout_logfile=/path/to/your/logs/celeryd.log
stderr_logfile=/path/to/your/logs/celeryd.log
autostart=true
autorestart=true
startsecs=10
stopwaitsecs=600
```

Just run supervisord in your project directory.
```
$ supervisord
```
Then, you can use the supervisorctl command to enter the interactive shell. Type help to get started. You can also execute supervisor command directly:
```
$ supervisorctl tail celeryd
$ supervisorctl restart celeryd
```