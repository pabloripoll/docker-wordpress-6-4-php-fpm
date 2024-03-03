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


## About

The goal of this container image is to provide a start up application with the basic enviroment to deploy a php service running with Nginx and PHP-FPM in a container for Wordpress and another, with a MySQL database to follow the best practices on an easy scenario to understand and modify at development needs.

Many repositories use the same internal docker network reflecting an only usage case when production is running on a WebHosting account where all is requirements are already set and running within the same server.

For this reason, I prefer to separate containers as they were different services with one for the application and another for the database.

On this configuration the connection between container are through the IP of the internal network the host *(your computer)* has.

*This repository does not include other services like message broker or mailing, etc.*

## Usage on Windows systems

This project has not been tested on Windows OS neither I use it to test it. So, I cannot bring to you much support on it.

I strongly recommend to use Makefile on Windows: https://stackoverflow.com/questions/2532234/how-to-run-a-makefile-in-windows

Anyway, using this repository you will needed to find out your PC IP by login as an `administrator user`.

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


## # Usage on Unix based systems

Find out your IP on UNIX systems and take the first ip listed
```bash
$ hostname -I

191.128.1.41 172.17.0.1 172.20.0.1 172.21.0.1
```

