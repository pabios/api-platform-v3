> composer require symfonycasts/micro-mapper

> php bin/console make:state-provider

> php php bin/console make:state-processor

 
>  git rm -r --cached .env

# Test
> composer require test 

```shell
    symfony php  bin/phpunit
    
    ✗ symfony console doctrine:database:create --env=test
    ✗ symfony console d:m:m --env=test
```

