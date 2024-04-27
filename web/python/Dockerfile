FROM python:3
USER root
WORKDIR /app
COPY python/src /app
COPY python/requirements.txt /app
RUN pip install --upgrade pip
RUN pip install --upgrade setuptools
RUN pip install -r /app/requirements.txt

# For check
# CMD ["python", "test.py"]

