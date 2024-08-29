#!/usr/bin/env sh
set -e

# Restore backup data
if [ -d "/export" ] && [ "$(ls -A /export)" ]; then
    mkdir -p /data/minio

    cp -r /export/* /data/minio

    echo "Restore backup data successfully!";
fi

minio server /data/minio --console-address ":8900";
