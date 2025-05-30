FROM python:3

WORKDIR /app
COPY web/python/src /app
COPY web/python/requirements.txt /app

RUN pip install --upgrade pip
RUN pip install --upgrade setuptools
RUN pip install -r /app/requirements.txt
RUN apt-get update
RUN apt install -y docker.io docker-compose
