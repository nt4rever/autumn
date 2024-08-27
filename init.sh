#!/bin/bash

if [ ! -f .env ]; then
    cp .env.example .env
fi

docker-compose -f docker-compose.yml up -d
