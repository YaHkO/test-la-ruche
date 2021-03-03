start:
	docker-compose up -d
	symfony console doctrine:migrations:migrate
	symfony serve -d

stop:
	docker-compose stop
	symfony server:stop

cc:
	php bin/console c:c
	symfony console c:c