from celery import Celery
from config import CONFIG

app = Celery('tasks', broker='amqp://localhost//', backend='db+mysql://'+CONFIG['uname']+':'+CONFIG['password']+'@'+CONFIG['host']+'/celery_tasks')

@app.task
def reverse(string):
    return string[::-1]