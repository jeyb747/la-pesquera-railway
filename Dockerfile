FROM php:8.2-apache

RUN a2enmod rewrite

RUN echo "<?php phpinfo(); ?>" > /var/www/html/index.php

EXPOSE 80

CMD ["apache2-foreground"]
