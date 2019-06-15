from celery import Celery

app = Celery('tasks', broker='amqp://localhost//')

@app.tasks
def reverse(string):
    return string[::-1]