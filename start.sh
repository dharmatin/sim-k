#!/bin/bash

docker run --rm -d --name sim-k -p 8080:80 -v $PWD/www:/var/www/site sim-k

