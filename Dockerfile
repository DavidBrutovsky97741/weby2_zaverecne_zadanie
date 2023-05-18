FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN apt-get update && apt-get install -y \
    libldap2-dev
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install ldap
RUN apt-get install octave -y
RUN apt-get install python3-pip -y
RUN pip install sympy
RUN octave --eval "pkg install -forge symbolic"