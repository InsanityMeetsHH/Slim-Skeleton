git status
git checkout production
git pull

# Install all or some packages
/usr/bin/php7.1-cli ../composer.phar update

# Add changes from entities to database
/usr/bin/php7.1-cli doctrine orm:schema-tool:update --force
