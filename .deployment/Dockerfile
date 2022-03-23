FROM ubuntu:20.04

ENV LANG C.UTF-8
ENV DEBIAN_FRONTEND=noninteractive

#Install default packages
RUN apt-get update \
&& apt-get -y install zip curl git vim lsb-release nginx cron ssh php php7.4-readline php7.4-zip php7.4-fpm php7.4-bcmath php7.4-xml php7.4-mysql php7.4-mongodb php7.4-mbstring  php-dev php-pear  \
build-essential cmake libeigen3-dev libboost-all-dev libcgal-dev libmpfr-dev libomp-dev m4 lzip php7.4-curl php-redis supervisor php-imagick ffmpeg \
php7.4-gd fontconfig-config freetype2-demos php7.4-pgsql telnet htop
#Install mongodb for php
#RUN pecl install mongodb
RUN apt-get -y install libpng-dev

RUN mkdir -p /run/php

#Install composer
RUN apt-get -y install composer
#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#&& php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
#&& php composer-setup.php \
#&& php -r "unlink('composer-setup.php');"
#
#RUN mv /composer.phar /usr/local/bin/composer

WORKDIR /var/www/

#Add config files / scripts
RUN mkdir -p /root/scripts /root/configfiles /root/.ssh
ADD ./scripts/docker-script-startup.sh /root/scripts/docker-script-startup.sh
ADD ./scripts/artisan_config.sh /root/scripts/artisan_config.sh
ADD ./ssh-keys/id_rsa /root/.ssh/id_rsa
ADD ./ssh-keys/id_rsa.pub /root/.ssh/id_rsa.pub
ADD ./configfiles/cli/php.ini /etc/php/7.4/cli/php.ini
ADD ./configfiles/cli/php.ini.bkp /etc/php/7.4/cli/php.ini.bkp
ADD ./configfiles/fpm/php.ini /etc/php/7.4/fpm/php.ini
ADD ./configfiles/fpm/php.ini.bkp /etc/php/7.4/fpm/php.ini.bkp
ADD ./configfiles/no-cors-nginx-site-config /etc/nginx/sites-available/default

#PHP configs
RUN sed -i 's,^upload_max_filesize =.*$,upload_max_filesize = 2048M,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^upload_max_filesize =.*$,upload_max_filesize = 2048M,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^error_reporting =.*$,error_reporting = E_ALL \& \~E_STRICT,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^error_reporting =.*$,error_reporting = E_ALL \& \~E_STRICT,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^post_max_size =.*$,post_max_size = 2048M,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^post_max_size =.*$,post_max_size = 2048M,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^max_execution_time =.*$,max_execution_time = 100,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^max_execution_time =.*$,max_execution_time = 100,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^max_input_time =.*$,max_input_time = 250,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^max_input_time =.*$,max_input_time = 250,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^;max_input_vars =.*$,max_input_vars = 5000,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^;max_input_vars =.*$,max_input_vars = 5000,' /etc/php/7.4/fpm/php.ini
RUN sed -i 's,^max_file_uploads =.*$,max_file_uploads = 200,' /etc/php/7.4/cli/php.ini
RUN sed -i 's,^max_file_uploads =.*$,max_file_uploads = 200,' /etc/php/7.4/fpm/php.ini

#Add Supervisor conf
COPY ./configfiles/supervisor/supervisord-api.conf /root/scripts/supervisord-api.conf
COPY ./configfiles/supervisor/supervisord-worker.conf /root/scripts/supervisord-worker.conf
COPY ./configfiles/supervisor/supervisord-api.conf /etc/supervisor/conf.d/supervisord.conf

#Add crontab to run backup script at 1AM Local Machine Time
RUN (crontab -l 2>/dev/null; echo "* * * * * chmod -R 777 /var/www/app-4bb61698/storage/logs/") | crontab -
RUN (crontab -l 2>/dev/null; echo "* * * * * /usr/bin/php /var/www/app-4bb61698/artisan schedule:run >> /dev/null 2>&1") | crontab -
RUN (crontab -l 2>/dev/null; echo "* * * * * /usr/bin/php /var/www/app-4bb61698/artisan queue:work --stop-when-empty") | crontab -

#Clone repo and install dependencies
RUN chmod 400 /root/.ssh/id_rsa
# RUN ssh-keyscan bitbucket.org > /root/.ssh/known_hosts
# RUN git clone git@bitbucket.org:cpdrenato/app-4bb61698.git -b master app-4bb61698

ADD ./configfiles/oauth-private.key /var/www/app-4bb61698/storage/oauth-private.key
ADD ./configfiles/oauth-public.key /var/www/app-4bb61698/storage/oauth-public.key

# RUN composer install -d /var/www/app-4bb61698

# RUN php /var/www/app-4bb61698/artisan config:clear
# RUN php /var/www/app-4bb61698/artisan config:cache

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www/app-4bb61698/storage 
        # \
        # /var/www/app-4bb61698/bootstrap/cache

#Set user folder
RUN chown -R www-data:root /var/www/app-4bb61698
RUN chmod -R 777 /var/www/app-4bb61698/storage
# RUN chmod -R 755 /var/www/app-4bb61698/bootstrap

# Install Node & NVM
RUN groupadd --gid 1000 node \
  && useradd --uid 1000 --gid node --shell /bin/bash --create-home node

# gpg keys listed at https://github.com/nodejs/node#release-team
RUN set -ex \
  && for key in \
    9554F04D7259F04124DE6B476D5A82AC7E37093B \
    94AE36675C464D64BAFA68DD7434390BDBE9B9C5 \
    FD3A5288F042B6850C66B31F09FE44734EB7990E \
    71DCFD284A79C3B38668286BC97EC7A07EDE3FC1 \
    DD8F2338BAE7501E3DD5AC78C273792F7D83545D \
    B9AE9905FFD7803F25714661B63B535A4C206CA9 \
    C4F0DFFF4E8C1A8236409D08E73BC641CC11F4C8 \
    56730D5401028683275BD23C23EFEFE93C4CFFFE \
  ; do \
    gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key" || \
    gpg --keyserver pgp.mit.edu --recv-keys "$key" || \
    gpg --keyserver keyserver.pgp.com --recv-keys "$key" ; \
  done

ENV NPM_CONFIG_LOGLEVEL info
ENV NODE_VERSION 16.14.2
# 8.9.3 | v16.14.2

RUN apt-get update && apt-get install -y curl xz-utils \
  && curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz" \
  && curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
  && gpg --batch --decrypt --output SHASUMS256.txt SHASUMS256.txt.asc \
  && grep " node-v$NODE_VERSION-linux-x64.tar.xz\$" SHASUMS256.txt | sha256sum -c - \
  && tar -xJf "node-v$NODE_VERSION-linux-x64.tar.xz" -C /usr/local --strip-components=1 \
  && rm "node-v$NODE_VERSION-linux-x64.tar.xz" SHASUMS256.txt.asc SHASUMS256.txt \
  && ln -s /usr/local/bin/node /usr/local/bin/nodejs

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash
RUN npm cache clean -f
RUN npm install -g n
RUN n stable
RUN node --version

# Install YARN
ENV YARN_VERSION 1.22.11
# 0.24.4

RUN set -ex \
  && for key in \
    6A010C5166006599AA17F08146C2130DFD2497F5 \
  ; do \
    gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key" || \
    gpg --keyserver pgp.mit.edu --recv-keys "$key" || \
    gpg --keyserver keyserver.pgp.com --recv-keys "$key" ; \
  done \
  && curl -fSL -o yarn.js "https://yarnpkg.com/downloads/$YARN_VERSION/yarn-legacy-$YARN_VERSION.js" \
  && curl -fSL -o yarn.js.asc "https://yarnpkg.com/downloads/$YARN_VERSION/yarn-legacy-$YARN_VERSION.js.asc" \
  && gpg --batch --verify yarn.js.asc yarn.js \
  && rm yarn.js.asc \
  && mv yarn.js /usr/local/bin/yarn \
  && chmod +x /usr/local/bin/yarn 

RUN npm install -g yarn  
RUN npx yarn-upgrade-all
RUN yarn global add yarn-upgrade-all
RUN npm install -g yarn-upgrade-all
RUN yarn-upgrade-all --global
RUN yarn add --dev yarn-upgrade-all
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn
RUN curl --compressed -o- -L https://yarnpkg.com/install.sh | bash
RUN yarn --version

# Clean packages
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#
EXPOSE 80 443

ENTRYPOINT [ "/root/scripts/docker-script-startup.sh" ]

#CMD ["/usr/bin/supervisord"]
