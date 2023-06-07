# DataScout API

1. Docker çalıştırma:
```
docker-compose up -d --build
```

2. PHP Docker container bash girme ve composer update:
```
docker exec -it datascout-api-php bash 
composer update
```

3. Veritabanı oluşturma & update:
```
php bin/console doctrine:database:create
sh dbupdate.sh
```


<hr>

API Platform Docs: ***https://localhost/api/docs***