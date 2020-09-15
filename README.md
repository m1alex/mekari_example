# mekari_example

## Preparing to install - LAMP, composer, etc

## 1. Go to projects place
    cd %PROJECTS PLACE%
    
## 2. Install application
    git clone https://github.com/m1alex/mekari_example.git
    
## 3. Create own database (mekari_example) in MySQL, create user and grantes
    CREATE DATABASE mekari_example CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    CREATE USER 'mekari_example'@'localhost' IDENTIFIED BY 'mekari_example';
    GRANT ALL PRIVILEGES ON mekari_example.* TO 'mekari_example'@'localhost';
    FLUSH PRIVILEGES;
    # DROP USER 'mekari_example'@'localhost';
    # DROP DATABASE mekari_example;

## 4. Update config
    cd mekari_example
    vim .env
        APP_URL=http://mekariexample.local
        DB_DATABASE=mekari_example
        DB_USERNAME=mekari_example
        DB_PASSWORD=mekari_example
    
## 5. Init application
    composer install
    php artisan migrate

## 6. Create dirs and access modes for cache&logs
    sudo mkdir storage/logs/httpd
    sudo chmod -R 0755 storage/logs/httpd
    sudo chmod -R 0755 storage 
    sudo chmod -R 0755 bootstrap/cache
    
## 7. Create virtual host in apache, e.g.:
    (You need set your real paths in DocumentRoot, Directory, ErrorLog, CustomLog)

    sudo vim /etc/apache2/sites-available/mekariexample.local.conf

        <VirtualHost *:80>
            ServerName mekariexample.local
            ServerAlias *.mekariexample.local
            ServerAdmin webmaster@localhost

            SetEnv LARAVEL_ENV dev

            DocumentRoot /home/alex/Documents/mekari/mekari_example/public

            <Directory />
                Deny from All
                Options None
                AllowOverride None
                Require all granted
            </Directory>

            <Directory /home/alex/Documents/mekari/mekari_example/public/>
                Options +FollowSymLinks
                AllowOverride All
                Order allow,deny
                Allow from All
            </Directory>

            LogLevel debug
            ErrorLog /home/alex/Documents/mekari/mekari_example/storage/logs/httpd/error.log
            CustomLog /home/alex/Documents/mekari/mekari_example/storage/logs/httpd/access.log combined

            ServerSignature Off
        </VirtualHost>

    apache2ctl configtest
    sudo a2ensite mekariexample.local.conf
    sudo service apache2 restart

    sudo vim /etc/hosts
        127.0.0.1   mekariexample.local

    sudo /etc/init.d/apache2 restart

## 8. Go to local site http://mekariexample.local
