#!/usr/bin/env sh
set -e

# Restore backup data
cp -r /export/* /data/minio;

minio server /data/minio --console-address ":8900";
