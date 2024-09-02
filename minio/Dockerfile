FROM minio/minio:latest

COPY ./scripts /scripts

RUN chmod +x /scripts/*

ENTRYPOINT ["/scripts/entrypoint.sh"]
