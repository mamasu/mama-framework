== Guia de instalacion de Mamaframework ==

# Descargar el framework con composer. Ir a https://git.mamasulabs.com/Mamaframework/Mamasu_Web_Framework
# Instalar base de datos ejecutando DumpTestDB
# El document root ha de apuntar a la carpeta public del proyecto

En este punto tendria ya que estar instalado

== Posibles mensajes de error ==

{| class="wikitable"
! style="text-align: center; font-weight: bold;" | Texto de error
! style="text-align: center; font-weight: bold;" | Correccion
|-
| <pre>{"success":false,"responseData":{"errorCode":1600,"errorMessage":"The URL not match with any of our defined routes"}}</pre>
| Ir a config/routing.ini para ver las rutas disponibles
|-
| <pre>{"success":false,"responseData":{"errorCode":0,"errorMessage":"Error trying to connect to db"}}</pre>
| Ir a config/config.ini para ver si el grupo db_default esta bien configurado
|-
| <pre>{"success":false,"responseData":{"errorCode":1500,"errorMessage":"User not allow to access"}}</pre>
| Ir a config/routing.ini para ver las rutas disponibles
|}



Install composer
========

php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php

php -r "if (hash_file('SHA384', 'composer-setup.php') === 'a52be7b8724e47499b039d53415953cc3d5b459b9d9c0308301f867921c19efc623b81dfef8fc2be194a5cf56945d223') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php

php -r "unlink('composer-setup.php');"

mv composer.phar /usr/local/bin/composer

Install project
=========

Usage:
-------
composer create-project  mmf/mmf [Directory name]


Example:
-------
composer create-project  mmf/mmf mmf