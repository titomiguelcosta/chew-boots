Chew Boots
==========

Playground for the AWS Batch service with PHP using the Symfony Console Component.

Script
------

Simple PHP 7.2 script that uploads a file to S3. Using the Symfony Console Component and the AWS SDK for PHP. 

The content and name of the file can be passed to the script through command line parameters.

Docker Image
------------

Create a docker image and upload it to AWS ECR.

$ aws ecr get-login --no-include-email --region us-east-1
$ docker build -t chew-boots .
$ docker tag chew-boots:latest 616022673352.dkr.ecr.us-east-1.amazonaws.com/chew-boots:latest
$ docker push 616022673352.dkr.ecr.us-east-1.amazonaws.com/chew-boots:latest

The default command run by the docker image accepts one argument and two options.

$ php bin/console chew-boots:s3:upload CONTENT --filename NAME --bucket NAME

AWS Batch
---------

Using the AWS Console, create a new job definition and queue using the docker image.

Use the AWS Console to add a new job or the CLI.

First create or make sure you have a profile with the settings to the AWS account you want to use.

$ export AWS_PROFILE=devops

Add the job to the queue

$ aws batch submit-job --job-queue chew-boots-job-queue  --job-definition chew-boots-job-definition --job-name hello --parameters content=hello 
