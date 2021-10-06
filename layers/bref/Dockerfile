ARG PHP_VERSION
FROM bref/php-$PHP_VERSION

# Remove file not needed
RUN rm /opt/bref/bootstrap.php

COPY bootstrap /opt/bootstrap
COPY bootstrap /var/runtime
