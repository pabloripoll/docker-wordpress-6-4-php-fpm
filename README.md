# Wordpress 6.4 with PHP FPM 8.3

Docker container image for Wordpress development

- [Wordpress 6.4](https://wordpress.org/download/releases/6-4/)

- [PHP-FPM 8.3](https://www.php.net/releases/8.3/en.php)

- [Nginx 1.24](https://nginx.org/)

- [Alpine Linux 3.19](https://www.alpinelinux.org/)

Repository: https://github.com/pabloripoll/docker-wordpress-6-4-php-8.3

* Built on the lightweight and secure Alpine Linux distribution
* Multi-platform, supporting AMD4, ARMv6, ARMv7, ARM64
* Very small Docker image size (+/-40MB)
* Uses PHP 8.3 for the best performance, low CPU usage & memory footprint
* Optimized for 100 concurrent users
* Optimized to only use resources when there's traffic (by using PHP-FPM's `on-demand` process manager)
* The services Nginx, PHP-FPM and supervisord run under a non-privileged user (nobody) to make it more secure
* The logs of all the services are redirected to the output of the Docker container (visible with `docker logs -f <container name>`)
* Follows the KISS principle (Keep It Simple, Stupid) to make it easy to understand and adjust the image to your needs

## [![Personal Page](https://pabloripoll.com/files/logo-light-100x300.png)](https://github.com/pabloripoll?tab=repositories)

## Project as Service

The goal of this container image is to provide a start up application with the basic enviroment to deploy a php service running with Nginx and PHP-FPM in a container which follows the best practices and is easy to understand and modify to your needs.

Thus not includes a database neither other services like message broker or mailing, etc.

## Usage on Windows systems

You can use the makefile that comes with this repository or manually update the [./docker/.env](./docker/.env) file to feed the `docker-compose.yml` file.

Find out your IP on Windows as `administrator user` and take the first ip listed
```bash
C:\WINDOWS\system32>ipconfig /all

Windows IP Configuration

 Host Name . . . . . . . . . . . . : 191.128.1.41
 Primary Dns Suffix. . . . . . . . : paul.ad.cmu.edu
 Node Type . . . . . . . . . . . . : Peer-Peer
 IP Routing Enabled. . . . . . . . : No
 WINS Proxy Enabled. . . . . . . . : No
 DNS Suffix Search List. . . . . . : scs.ad.cs.cmu.edu
```

## Usage on Unix based systems

Makefiles are often used to automate the process of building and compiling software on Unix-based systems, including Linux and macOS.

Checkout the Mkaefile recepies:
```
$ make help
```

Example:
```
$ make host-check

Checking configuration for MY PHP APP container:
MY PHP APP > port:8888 is free to use.
```

Build container
```bash
$ make build
[+] Building 33.0s (25/25) FINISHED                                                                               docker:default
 => [slight83 internal] load build definition from Dockerfile                                                     0.0s
 => => transferring dockerfile: 2.43kB
...
 => => exporting layers                                                                                           0.7s
 => => writing image sha256:05b7369d7c730f1571dbbd4b46137a67c9f87c5ef9fa686225cb55a46277aca1                      0.0s
 => => naming to docker.io/library/slight83:php-8.3-alpine-3.19                                                   0.0s
[+] Running 1/2
 ⠦ Network myphp_default  Created                                                                                 0.6s
 ✔ Container myphp        Started
```

Up container
```bash
$ make up
[+] Running 1/1
 ✔ Container myphp  Started               0.4s
Container Host:
172.19.0.2
Local Host:
localhost:8888
127.0.0.1:8888
191.128.1.41:8888
```

Build & Up container
```bash
$ make build up
[+] Building 32.4s (25/25) FINISHED
...
```
TOTAL TIME: 32.4s

Stop container
```bash
$ make stop
[+] Killing 1/1
 ✔ Container myphp  Killed                  0.4s
Going to remove myphp
[+] Removing 1/0
 ✔ Container myphp  Removed
```

Clear container network
```bash
$ make clear
[+] Running 1/1
 ✔ Network myphp_default  Removed
```

## Docker Info

Docker container
```bash
$ sudo docker ps -a
CONTAINER ID   IMAGE      COMMAND    CREATED         STATUS                     PORTS                                             NAMES
0f94fe4739a6   php-8...   "doc…"     2 minutes ago   Up 2 minutes (unhealthy)   9000/tcp, 0.0.0.0:8888->80/tcp, :::8888->80/tcp   myphp
```

Docker image
```bash
$ sudo docker images
REPOSITORY   TAG           IMAGE ID       CREATED         SIZE
php-8.3      alpine-3.19   8f7db0dfcde1   3 minutes ago   199MB
```

Docker stats
```bash
$ sudo docker system df
TYPE            TOTAL     ACTIVE    SIZE      RECLAIMABLE
Images          1         1         199.5MB   0B (0%)
Containers      1         1         33.32MB   0B (0%)
Local Volumes   1         0         117.9MB   117.9MB (100%)
Build Cache     39        0         10.21kB    10.21kB
```

Removing container and image generated
```bash
$ sudo docker system prune
...
Total reclaimed space: 116.4MB
```
*(no need for pruning volume)*

## Reset configurations on the run
In [docker/config/](docker/config/) you'll find the default configuration files for Nginx, PHP and PHP-FPM.

If you want to extend or customize that you can do so by mounting a configuration file in the correct folder;

Nginx configuration:
```bash
$ docker run -v "`pwd`/nginx-server.conf:/etc/nginx/conf.d/server.conf" ${COMPOSE_PROJECT_NAME}
```

PHP configuration:
```bash
$ docker run -v "`pwd`/php-setting.ini:/etc/php83/conf.d/settings.ini" ${COMPOSE_PROJECT_NAME}
```

PHP-FPM configuration:
```bash
$ docker run -v "`pwd`/php-fpm-settings.conf:/etc/php83/php-fpm.d/server.conf" ${COMPOSE_PROJECT_NAME}
```

_Note; Because `-v` requires an absolute path I've added `pwd` in the example to return the absolute path to the current directory_


## Troubleshoots

If you want to connect to another container running your local machine *(for e.g.: database, bucket)* use your ip to do so *(not localhost or 127.0.0.1)*.

Find out your IP on UNIX systems and take the first ip listed
```bash
$ hostname -I

191.128.1.41 172.17.0.1 172.20.0.1 172.21.0.1
```

# Docker Wordpress

Comes with an existing database but you can start the project from start up Wordpress


Container image for Docker *(development test)*

## Acerca del proyecto de prueba

Desarrollo realizado en Linux con Docker y Docker Compose, administrado por un Makefile.

En caso de que no se posea un ordenador con sistema operativo basado en Unix, una copia de la base de datos se encuentra en la dirección [resources/database/wordpress.sql](resources/database/wordpress.sql) para su importación.

Si éste proyecto se ejecutare bajo otra plataforma de servidor local como Apache ó Nginx, como así también con MySQL / MariaDB interno, migrar la base de datos y actualizar en la misma la URL del proyecto de wordpress de `http://localhost:8888` por el requerido en las tablas `wp_options` y `wp_users`.

## Ejecución del proyecto con Docker

#### Antes de comenzar

El proyecto posee dos contenedores, uno con Wordpress y otro con la base de datos. Si bien se puede construir bajo una misma red interna de docker, solo refleja el caso de uso en producción dentro de un mismo servidor, pero no si éste se encontraría en dos servicios ó instancias por separado.

Por eso, suelo optar mantener separado un contenedor exclusivo para la base de datos. Para esto, la conexión entre los conectores debe hacerse a través de la IP de la red interna que posee el ordenador "Host".

Abrir el fichero `wp-config` y actualizar la ip del ordenador `Database hostname` y dejar el puerto si es el mismo pre-establecido.
```php
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

/** Database hostname */
define( 'DB_HOST', '192.168.1.41:8889' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
```

## Automatizaciones

Para comenzar, realizar una copia en la raíz del proyecto del fichero [.env.example](.env.example) con el nombre `.env`

Creado el fichero `.env` lo único necesario para utilizar la aplicación son los siguientes comandos:

Primero crear y levantar los contenedores
```bash
$ make project-start
```

Finalizado el anterio proceso, importar la base de datos
```bash
$ make database-install
```

Con esto, solo queda dirigirse la administrador de wordpress en <a href="http://localhost:8888/wp-admin/" target="_blank">http://localhost:8888/wp-admin/</a> y añadir el usuario administrador de prueba:
- admin
- 123456

## Finalizar Contenedores

Con el siguiente comando se detendrá los contenedores y eliminarán las redes internas de docker creadas
```bash
$ make project-stop
```

Solo quedaría eliminar las imágenes creadas y realizar un `docker system prune` para limpiar docker.

---