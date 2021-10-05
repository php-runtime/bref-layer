ARG PHP_VERSION
FROM bref/php-$PHP_VERSION

# Remove some bref files
RUN rm /opt/bref/bootstrap.php

COPY bootstrap /opt/bootstrap
COPY bootstrap /var/runtime
