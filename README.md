## Inncloud Prueba tecnica BackEnd

Este es el frontEnd de la prueba tecnica para mi postulacion en incloud

Recomiendo hacer el proceso de ejecucion de este backend primero ya que este necesita de el backend para que funcione el frontend.

El repositorio dedicado al frontend es el siguiente:
https://github.com/Miguelarias0413/xyz_commerce-FRONTEND.git


# ¿Como ejecutar?

Clona este proyecto
```bash
git clone https://github.com/Miguelarias0413/xyz_commerce-BACKEND.git
```
Entra a la carpeta seleccionada e instala las dependencias dentro del directorio
```bash
composer install
```
Una vez las dependencias se hayan instalado, configura el archivo .env con la contraseña adecuada a tu gestor de db si es que tienes contraseña, por el contrario dejalo vacio y ejecuta las migraciones con el siguiente comando
```bash
php artisan migrate
```
Llena las tablas necesarias para las pruebas con el siguiente comando
```bash
php artisan db:seed
```
Por ultimo para poner el servidor en ejecucion ejectuta el siguente comando
```bash
php artisan serve
```

Ya con el backend con el servidor ejecutandose ya este projecto de react deberia funcionar con normalidad

## Video presentacion y tutorial de parte mia 

https://www.youtube.com/watch?v=1BagiTicEbI&ab_channel=MiguelAngelAriasGarcia
