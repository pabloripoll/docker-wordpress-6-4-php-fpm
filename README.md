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

*At the moment, this repository does not include other services like message broker or mailing, etc.*

## [![Personal Page](https://pabloripoll.com/files/logo-light-100x300.png)](https://github.com/pabloripoll?tab=repositories)

## About

The objective of this repository is having a CaaS [Containers as a Service](https://www.ibm.com/topics/containers-as-a-service) to provide a start up application with the basic enviroment features to deploy a php service running with Nginx and PHP-FPM in a container for Wordpress and another container with a MySQL database to follow the best practices on an easy scenario to understand and modify at development requirements.

The configuration for the connection between container is as [Host Network](https://docs.docker.com/network/drivers/host/) on `eth0`, thus both containers do not share networking or bridge.

To access the containers as client it can be done through localhost:${PORT} bu the connection between containers is through the Host IP.

#### Containers on Windows systems

This project has not been tested on Windows OS neither I can use it to test it. So, I cannot bring much support on it.

Anyway, using this repository you will needed to find out your PC IP by login as an `administrator user` to set connection between containers.

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

Take the first ip listed because through it, Wordpress container will connect with database container.

#### Containers on Unix based systems

Find out your IP on UNIX systems and take the first IP listed
```bash
$ hostname -I

191.128.1.41 172.17.0.1 172.20.0.1 172.21.0.1
```

#### Docker container for Wordpress configuration

Having the Host IP, open [wordpress/wp-config.php](wordpress/wp-config.php) to set the  `Database hostname`. For this example parameters comes from a created `.env` file copied from `.env.example`. *(this can be done automatically by using Composer package DOTENV)*

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

## Automatization with Makefile

*I strongly recommend to use Makefile on Windows: https://stackoverflow.com/questions/2532234/how-to-run-a-makefile-in-windows*

## Content

Directories and main files on a tree architecture description
```
.
│
├── docker
│   ├── mariadb
│   │   ├── ...
│   │   ├── .env.example
│   │   └── docker-compose.yml
│   │
│   └── nginx-php
│       ├── ...
│       ├── .env.example
│       └── docker-compose.yml
│
├── resources
│   ├── database
│   │   └── wordpress.sql
│   │
│   ├── plugin
│   │   ├── dev
│   │   ├── {plugin-version}
│   │   └── {plugin-version}.zip
│   │
│   ├── theme
│   │   ├── dev
│   │   ├── {theme-version}
│   │   └── {theme-version}.zip
│   │
│   └── wordpress
│       └── any file or directory required for the re-build of the wordpress app...
│
├── wordpress
│   └── application...
│
├── .env (must be created manually)
├── .env.example
└── Makefile
```

Makefile recipies
```bash
$ make help
usage: make [target]

targets:
Makefile  help                     shows this Makefile help message
Makefile  hostname                 shows local machine ip
Makefile  fix-permission           sets project directory permission
Makefile  ports-check              shows this project ports availability on local machine
Makefile  wordpress-set            sets the Wordpress PHP enviroment file to build the container
Makefile  wordpress-build          builds the Wordpress PHP container from Docker image
Makefile  wordpress-start          starts up the Wordpress PHP container running
Makefile  wordpress-stop           stops the Wordpress PHP container but data will not be destroyed
Makefile  wordpress-destroy        stops and removes the Wordpress PHP container from Docker network destroying its data
Makefile  database-set             sets the database enviroment file to build the container
Makefile  database-build           builds the database container from Docker image
Makefile  database-start           starts up the database container running
Makefile  database-stop            stops the database container but data will not be destroyed
Makefile  database-destroy         stops and removes the database container from Docker network destroying its data
Makefile  database-replace         replace the build empty database copying the .sql backfile file into the container raplacing the pre-defined database
Makefile  database-backup          creates a copy as .sql file from container to a determined local host directory
Makefile  project-set              sets both Wordpress and database .env files used by docker-compose.yml
Makefile  project-build            builds both Wordpress and database containers from their Docker images
Makefile  project-start            starts up both Wordpress and database containers running
Makefile  project-stop             stops both Wordpress and database containers but data will not be destroyed
Makefile  project-destroy          stops and removes both Wordpress and database containers from Docker network destroying their data
Makefile  repo-flush               clears local git repository cache specially to update .gitignore
```