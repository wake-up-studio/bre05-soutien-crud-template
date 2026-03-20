!#bin/bash

mkdir "$1"

mkdir "$1/assets"
touch "$1/assets/.gitkeep"

mkdir "$1/config"
touch "$1/config/autoload.php"

mkdir "$1/controllers"
touch "$1/controllers/.gitkeep"

mkdir "$1/models"
touch "$1/models/.gitkeep"

mkdir "$1/managers"
touch "$1/managers/.gitkeep"

mkdir "$1/templates"
touch "$1/templates/layout.phtml"

mkdir "$1/services"
touch "$1/services/Router.php"

touch "$1/index.php"