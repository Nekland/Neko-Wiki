php app/console doctrine:database:create -e=test
php app/console doctrine:schema:create -e=test
php app/console doctrine:fixture:load -e=test --no-interaction
