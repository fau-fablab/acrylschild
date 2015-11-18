FROM ubuntu:14.04

ENV	DEBIAN_FRONTEND noninteractive

# install packages
RUN	apt-get update
RUN	apt-get -y upgrade
RUN	apt-get -y install apache2 php5

# configure
RUN	rm -r /var/www/html/
RUN	sed -i "s/\\/var\\/www\\/html/\\/var\\/www/" "/etc/apache2/sites-available/000-default.conf"
RUN	sed -i "s/\\/var\\/www\\/html/\\/var\\/www/" "/etc/apache2/apache2.conf"

# create files folder
RUN	mkdir -p /tmp/files
RUN	chown -R www-data:www-data /tmp/files

CMD	ln -s /tmp/files /var/www/files && \
	. /etc/apache2/envvars && \
	apachectl -e info -DFOREGROUND
