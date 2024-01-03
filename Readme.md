```shell
rm -rf var/cache/*
```
> 
> > composer require symfonycasts/micro-mapper

> php bin/console make:state-provider

> php php bin/console make:state-processor

 
>  git rm -r --cached .env

# Test
> composer require test 

```shell
    symfony php  bin/phpunit
    
    ✗ symfony console doctrine:database:create --env=test
    ✗ symfony console d:m:m --env=test
    
  
    ✗ symfony php  bin/phpunit --filter=testPostToCreateProduct
```


# Fixtures
```shell
composer require foundry orm-fixtures --dev
php bin/console make:factory
```
* edit load XFactory.php i.e x == entityName

```shell
symfony console doctrine:fixtures:load
```

