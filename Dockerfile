FROM php:7.2-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN echo "date.timezone=UTC" >> $PHP_INI_DIR/php.ini
RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20170718/xdebug.so" >> $PHP_INI_DIR/php.ini
RUN apk --no-cache add git unzip make autoconf alpine-sdk
RUN pecl install xdebug
RUN export EXPECTED_SIGNATURE=$(curl -s https://composer.github.io/installer.sig) \
  && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && export ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');") \
  && if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then echo 'ERROR: Invalid installer signature'; rm composer-setup.php; exit 1; fi \
  && php composer-setup.php --quiet --install-dir=/usr/local/bin --filename=composer
