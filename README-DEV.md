- [ ] TODO: Include details on how to get a log in to wp-admin once everything's installed.
- [ ] TODO: Include list of caveats: You may have to run that global search-and-replace more than once, it's a big database
- [ ] TODO: Caveat: Properties with hyphens in their name should not be tested against on localhost
- [ ] TODO: Include info on pros/cons of symlinking ahtheme, plugins into wordpress install.
- [ ] TODO: Include caveat on file ownership of wp-config, once it's copied from the repo.
- [ ] TODO: Include wordpress version information and link to wordpress download page
- [ ] TODO: Include an example of a working apache site conf file
- [ ] TODO: Include note about when you first edit a post in the wp-admin, make sure the "Custom Fields" checkbox (in the Screen Options tab, at the top right of the page) is checked

All this is setting up in a MAMP install with htdocs as the root which contains the wordpress core files. I suspect WAMP is similar.

## MAMP/WAMP
In MAMP/WAMP make sure in preferences you are using Apache Port 80 and MySQL Port 3306
 
* In phpmyadmin import the db into a new database. (sql file is in this directory).
 
- Change the wp-config.php (Its different than the stock wp install, you need to add some stuff for multisite so I included in this directory replace it with this one) file to reflect your database info. In MAMP my info looks something like this.
```php
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'newdbagainmc');
 
/** MySQL database username */
define('DB_USER', 'root');
 
/** MySQL database password */
define('DB_PASSWORD', 'root');
 
/** MySQL hostname */
define('DB_HOST', 'localhost');
```

* While you are in wp-config.php, COMMENT OUT the line  [define( 'SUNRISE', 'on' );] ( we are not mapping domains in DEV so it's not used. Only used for production, you can also remove the sunrise.php file from wp-content.)
 
 
* I uploaded this tool to the git too, it's in the directory Search-Replace-DB. I put the searchreplacedb2.php file in the root and navigate to it in your browser -  http://localhost/searchreplacedb2.php
follow the steps.
 
If you are using a different database, say from the production site you will need to search for the ip or domain name that is being used for that install.

The SQL file I have in this folder is ALREADY USING LOCALHOST so you can skip this step if you are using it.

Search for - localhost

Replace with - whatever-your-domain-is
 
After that run the tool again.
 
If you are using MAMP on a mac you won't need to this step. I don't know what the path looks like on a PC.
Search for -  /Applications/MAMP/htdocs  (or the file path to your htdocs)
Replace with - The Path to your WAMP htdocs

## UBUNTU STUFF
the file path is /var/www 

You need to go to something like /etc/apache2/sites-enabled/000-default  (default is the config file for your local site)
edit this file and make sure AllowOverride all and mod_rewrite is enabled. Restart Apache sudo service apache2 graceful

* In htdocs or www make sure you have this in your .htaccess file.

```
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?files/(.+) wp-includes/ms-files.php?file=$2 [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^[_0-9a-zA-Z-]+/(wp-(content|admin|includes).*) $1 [L]
RewriteRule ^[_0-9a-zA-Z-]+/(.*\.php)$ $1 [L]
RewriteRule . index.php [L]
```


### Apache Errors I've seen (and, eventually, how to fix them)
    [Wed Feb 13 13:45:38 2013] [error] [client 127.0.0.1] File does not exist: /var/www/mediac/lcsun-news


# Other notes
## How I got APC caching installed
```bash
sudo apt-get install php5-dev
sudo apt-get install libpcre3-dev
sudo pecl install apc-3.1.4
# Edit php.ini, add extension=apc.so on its own line
# Test if APC's enabled:
php -i | grep apc
```
(Also useful: http://blog.janjonas.net/2010-09-25/ubuntu-10_04-setup-apc-php_5_3-apache2 )


## Make sure your PHP supports short open tags
As of October 2013, there are portions of the mcenter theme that use short open tags.

## Make sure your PHP supports short open tags
As of October 2013, there are portions of the mcenter them that use short open tags.

http://www.php.net/manual/en/ini.core.php#ini.short-open-tag

## Make sure you have the multisite-specific config lines in your wp-config.php
These are currently lines 86-96 in the wp-config in this helpstuff dir.

## dfm-wp-photogallery is installed and activated but no galleries appear.
You may see 404s on http://localhost/wp-content/plugins/dfm-wp-photogallery/js/json/blahblah.json requests. In that case the cache directory in [cachedir] permissions need to be adjusted.
```bash
cd /var/www/wp/wp-content/plugins/dfm-wp-photogallery/js
chmod 0777 json
```
