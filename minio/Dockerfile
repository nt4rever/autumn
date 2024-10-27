FROM minio/minio:RELEASE.2024-10-13T13-34-11Z

COPY ./scripts /scripts

RUN chmod +x /scripts/*

ENTRYPOINT ["/scripts/entrypoint.sh"]
