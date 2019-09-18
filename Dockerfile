FROM php:7.3-alpine

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# avro-to-php
RUN composer global require chasdevs/avro-to-php

ENTRYPOINT ["avro-to-php"]
CMD ["compile:directory", "."]