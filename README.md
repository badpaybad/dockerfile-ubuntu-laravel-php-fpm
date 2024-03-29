# Dockerfile

php8.0 + php8.0-fpm + nginx + php composer

folder structor for config nginx, php, php fpm. nginx listen in port 80, root dir /usr/share/nginx/html/public;

You should copy folder : server and file Dockerfile to you Laravel project

                /app
                /public                
                /Dockerfile 
                /server
                |--/etc
                   |--/nginx
                   |--/php
                      |--/8.0
                         |--php.ini

               
               COPY server/etc/php/cli-php.ini /etc/php/8.0/cli/php.ini
               COPY server/etc/nginx /etc/nginx
                   

You can volume mount some log folder in need. Build and run docker, you need cmd in current folder with dockerfile (the folder of this git)

                docker build -t testlaravel .
                docker run -d -p 8889:80 testlaravel 

Should add your own .env 

                COPY ./.env.example /usr/share/nginx/html/.env
# Inside docker

Can do copy from docker to outside to check
                
                docker cp {container id}:{path inside container} {path your PC}

                docker cp 7c78e42ab9ad:/etc/php/8.0/cli/php.ini d:/cli-php.ini

                docker cp 7c78e42ab9ad:/etc/php/8.0/fpm/php-fpm.conf d:/php-fpm.conf

                docker cp 7c78e42ab9ad:/etc/php/8.0/fpm/php.ini d:/fpm-php.ini

                docker cp 77aa911d2a3d:/etc/php/8.0/fpm/pool.d/www.conf d:/www.conf

Config will map to 

               /etc/nginx/nginx.conf
               /etc/nginx/conf.d/default.conf
               /etc/php/8.0/fpm/php-fpm.conf
               /etc/php/8.0/fpm/php.ini
               /etc/php/8.0/cli/php.ini
               /etc/php/8.0/fpm/pool.d/www.conf

### should care about
                
server/etc/php/8.0/fpm/pool.d/www.conf
                
                listen = /run/php/php8.0-fpm.sock                                

server/etc/php/8.0/fpm/php-fpm.conf

                pid = /run/php/php8.0-fpm.pid                
                include=/etc/php/8.0/fpm/pool.d/*.conf
                
server/etc/nginx/conf.d/default.conf
                               
                root /usr/share/nginx/html/public;          

Dockerfile

                CMD ["/bin/bash", "-c", "php-fpm8.0 && chmod 777 /var/run/php/php8.0-fpm.sock && nginx -g 'daemon off;'"]
                COPY ./ /usr/share/nginx/html/

### Your source code
            
                ##your source
                COPY ./ /usr/share/nginx/html/

### /server/php/php.ini

Your need install you own php extensions, and modify php.ini. Docker file should RUN apt ...your php ext...

## Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# ref docker file


ref nginx : https://github.com/johnathanesanders/docker-nginx-fpm

php8.0 https://bobcares.com/blog/install-php-8-on-ubuntu-20-04/
