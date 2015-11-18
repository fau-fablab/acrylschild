FROM ubuntu:14.04

ENV DEBIAN_FRONTEND noninteractive

# install packages
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get -y install apache2 php5

# configure
RUN ["rm", "-r", "/var/www/html/"]
RUN ["sed", "-i", "s/\\/var\\/www\\/html/\\/var\\/www/", "/etc/apache2/sites-available/000-default.conf"]
RUN ["sed", "-i", "s/\\/var\\/www\\/html/\\/var\\/www/", "/etc/apache2/apache2.conf"]

COPY . /var/www/

# fix permissions
RUN ["chown", "-R", "root:www-data", "/var/www/"]
RUN ["mkdir", "-p", "/var/www/files"]
RUN ["chown", "-R", "www-data:www-data", "/var/www/files"]

CMD . /etc/apache2/envvars && apachectl -e info -DFOREGROUND
