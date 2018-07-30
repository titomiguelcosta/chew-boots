FROM php:7.2-cli

ADD . /app
WORKDIR /app

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install

CMD ["php", "bin/console", "chew-boots:s3:upload", "test"]