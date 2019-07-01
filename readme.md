# Asynchronous Processing with RabbitMQ and Celery

When building web applications, you will inevitably find certain actions that are taking too long and as a result must be pulled out of the http response cycle. These actions can be performed asynchronously with rabbitmq and celery.

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

#### Run celery worker
```
$ celery -A tasks worker --loglevel=info
```

## Start the Workers as Daemons
In a production environment with more than one worker, the workers should be daemonized so that they are started automatically at server startup.

Using sudo, create a new service definition file in /etc/systemd/system/celeryd.service. Change the User and Group properties according to your actual user and group name:

##### /etc/systemd/system/celeryd.service
```
[Unit]
Description=Celery Service
After=network.target

[Service]
Type=forking
User=celery
Group=celery
EnvironmentFile=/etc/default/celeryd
WorkingDirectory=/home/celery/tasks
ExecStart=/bin/sh -c '${CELERY_BIN} multi start ${CELERYD_NODES} \
  -A ${CELERY_APP} --pidfile=${CELERYD_PID_FILE} \
  --logfile=${CELERYD_LOG_FILE} --loglevel=${CELERYD_LOG_LEVEL} ${CELERYD_OPTS}'
ExecStop=/bin/sh -c '${CELERY_BIN} multi stopwait ${CELERYD_NODES} \
  --pidfile=${CELERYD_PID_FILE}'
ExecReload=/bin/sh -c '${CELERY_BIN} multi restart ${CELERYD_NODES} \
  -A ${CELERY_APP} --pidfile=${CELERYD_PID_FILE} \
  --logfile=${CELERYD_LOG_FILE} --loglevel=${CELERYD_LOG_LEVEL} ${CELERYD_OPTS}'

[Install]
WantedBy=multi-user.target
```

Create a/etc/default/celeryd configuration file:

##### /etc/default/celeryd
```
# The names of the workers. This example create two workers
CELERYD_NODES="worker1 worker2"

# The name of the Celery App, should be the same as the python file
# where the Celery tasks are defined
CELERY_APP="downloaderApp"

# Log and PID directories
CELERYD_LOG_FILE="/var/log/celery/%n%I.log"
CELERYD_PID_FILE="/var/run/celery/%n.pid"

# Log level
CELERYD_LOG_LEVEL=INFO

# Path to celery binary, that is in your virtual environment
CELERY_BIN=/home/celery/miniconda3/bin/celery
```

#### Create log and pid directories:
```
$ sudo mkdir /var/log/celery /var/run/celery
$ sudo chown celery:celery /var/log/celery /var/run/celery
```

#### Reload systemctl daemon. You should run this command each time you change the service definition file.
```
$ sudo systemctl daemon-reload
```

#### Enable the service to startup at boot:
```
$ sudo systemctl enable celeryd
```

#### Start the service
```
$ sudo systemctl start celeryd
```

#### Check that your workers are running via log files:
```
$ cat /var/log/celery/worker1.log
$ cat /var/log/celery/worker2.log
```

## Monitor Celery with Flower

Flower is a web based tool for monitoring and administrating Celery clusters.

#### Install Celery Flower

```
$ pip3 install flower
```

#### Launch the server and open http://localhost:5555:
```
$ flower --port=5555
```
## Flower as Daemon

Create a systemd configuration file called flower.service, located in /etc/systemd/system folder.

##### /etc/systemd/system/flower.service
```
[Unit]
Description=Flower Celery Service

[Service]
User=user
Group=group
WorkingDirectory=/var/www/project-working-directory
ExecStart=/home/user/virtualenv/bin/flower --port=5555
Restart=on-failure
Type=simple

[Install]
WantedBy=multi-user.target
```

#### Reload systemd daemon 
```
$ sudo systemctl daemon-reload
```

#### Start a flower daemon
```
$ sudo systemctl start flower
```