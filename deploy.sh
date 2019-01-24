git status
git checkout production
git pull

# Install all or some packages
php composer install

# Add changes from entities to database
php doctrine orm:schema-tool:update --force
