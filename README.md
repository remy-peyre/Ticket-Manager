Ticket-Manager
==============

A Symfony project created on November 10, 2017, 12:02 pm.

`git clone`

`composer install`

`php bin/console doctrine:schema:update --dump-sql`

`php bin/console doctrine:schema:update --force`

If you want create an admin :

`php bin/console fos:user:create USERNAME --super-admin`

`php bin/console fos:user:promote testuser ROLE_ADMIN`