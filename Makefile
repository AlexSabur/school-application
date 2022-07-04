ide-helper:
	php artisan clear-compiled
	php artisan ide-helper:generate
	php artisan ide-helper:meta
	php artisan ide-helper:models --nowrite
build:
	docker build -t school .
run:
	docker run -p 81:80 school
