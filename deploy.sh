git status
git pull

/usr/bin/php7.1-cli ../composer.phar install
/usr/bin/php7.1-cli doctrine orm:schema-tool:update --force
