# CRUD Animales (PHP + MongoDB)

Campos: nombre, edad, especie, raza, dueño.

## Requisitos
- PHP 8.x con extensión `mongodb` habilitada
- Composer
- MongoDB en `mongodb://127.0.0.1:27017`
- Apache (o PHP built-in server)

## Instalación rápida
```bash
cd /var/www/html
sudo mkdir -p crud_animales_php_mongodb
sudo chown -R $USER:$USER crud_animales_php_mongodb


cd crud_animales_php_mongodb
composer install
cp .env.example .env



php -S 127.0.0.1:8000 -t public
```
