## Demarrer le projet avec docker

>> git clone https://github.com/philippelamny/Formation__Approche_DDD.git


>> cd Formation__Approche_DDD


>> docker-compose build

>> docker-compose run todolist composer install


>> cp todolist/.env.example todolist/.env


>> docker-compose run todolist php artisan key:generate


>> docker-compose down


>> docker-compose up -d


## Command utile

Vérifier la page :  http://localhost:8000


Lancer les tests avec le mode verbose :  docker-compose exec todolist php artisan test


Connaitre toutes les routes disponibles : docker-compose exec todolist php artisan route:list

