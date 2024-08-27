up:
	sh init.sh
down:
	docker compose down
dev:
	docker compose -f docker-compose.dev.yml up -d
dev-down:
	docker compose -f docker-compose.dev.yml down
