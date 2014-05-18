<VirtualHost *:80>
    ServerName f.s.p
    DocumentRoot /var/www/finish/public
    <Directory /var/www/finish/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>

