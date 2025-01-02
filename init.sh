#!/bin/bash

if [ ! -f maple/.env ]; then
    cp maple/.env.example maple/.env
fi

docker compose -f docker-compose.yml up -d
