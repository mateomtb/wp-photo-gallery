# Heck yes I want a dev environment.
Get a dev environment set up! Yes, you! 

* Install wordpress. I installed it to /var/www/bt, your setup may differ. 
* Edit your wp-config.php file. It's in the wordpress root. It will ask you for database information...
* Create a database for your blog. Name it whatever you want. There are many ways to create a database, hopefully you know one.
* Go into wp-content and delete both your themes and plugins dir.
Symlink themes and plugins to wp-content/themes. i.e. if you're in wp-content, ``ln -s /full/path/to/themes/in/your/repo`` and ```ln -s /full/path/to/plugins/in/your/rep
* Do the same for plugins.
* While you're at it you'll need the submodules. ``git submodule init; git submodule update`` from the repo root.
* Log into your WP install localhost/bt/wp-admin enter some generic details as prompted and go to the admin. dont' worry what you enter will be vaped when we import a DB later. (DO NOT ACTIVATE ANY PLUGINS OR A THEME!!!!!)
* In your hosts file let's point to an easy to use name for the url of the site something like  localhost   bt
* MAC MAMP  sudo vi /etc/hosts     127.0.0.1       bt  (localhost doesn't work).
* Use the apache virtual host file in the dev folder (may need to adjust wordpress directory paths) to point your webserver to that domain. Put that file in your ``/path/to/apache2/sites-enabled/`` .
* Restart apache. On linux that's ``sudo service apache2 restart``
* MAC Virtual stuff here
* MAC MAMP vi /Applications/MAMP/conf/apache/httpd.conf  uncomment the include around line 524
```
524 # Virtual hosts
525 Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf

vi /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf  add something like this to that file
<VirtualHost *:80>
    DocumentRoot "/Applications/MAMP/htdocs/"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "/Applications/MAMP/htdocs/btown"
    ServerName bt
</VirtualHost>
```
* MAC MAMP - restart server from MAMP control panel
* In the WP admin go to Settings -> General and change the Site Address (URL) and WordPress Address (URL) to the new virtual name you just created like http://bt save the changes. You should now be able to go to http://bt/wp-admin
* Change the permissions on your wp-content directory. Either change the owner to the same owner of your webserver processes, or run ``sudo chmod 0777 wp-content`` from the wordpress root.
* We now need to turn WP into a multisite install. Start at step 2 here http://codex.wordpress.org/Create_A_Network   Choose a sub directory site - Paste the 2 chunks of code in the appropriate files
* In the WP admin go to My Sites -> Network -> Plugins and activte 2 plugins WP Migrate DB Pro and WP Migrate DB Pro Media Files (DO NOT ACTIVATE ANY OTHER PLUGINS OR A THEME)
* Go to My Sites -> Network -> Settings -> Migrate DB Pro 
* Go to the Help tab and watch the second video Pulling Live Data Into Your Local Development Environment Here are the bits of info you will need to enter in the plugin.

```
Connection Info - Site URL & Secret Key
https://wp-news.digitalfirstmedia.com
Y2mHgg6sM3LnjXjqbRRIFmPrM2XWTQZG

The license
ae7dc8d1-0112-4d4f-a054-b2d7963728f6
```

*Once all this has completed you will have a working local dev just like staging. Keep in mind since you imported the DB all the credentials will now match the stage server so you will need to now login like this to your local http://bt/wp-admin

```
wp creds for staging
http://wp-news.digitalfirstmedia.com/wp-admin
dfmstaging
ned4eva!*

```


For reference, here's the history from a recent bt-wp install, warts and all:

```
 1344  git clone https://github.com/dfmedia/bt-wp
 1345  cd bt-wp/
 1346  git submodule init
 1347  git submodule update
 1348  cd /var/www/
 1349  ls
 1350  history | grep wp
 1351  sudo svn co http://core.svn.wordpress.org/tags/3.8/ bt
 1352  cd bt
 1353  ls
 1354  mv wp-config-sample.php wp-config.php
 1355  sudo mv wp-config-sample.php wp-config.php
 1356  vi wp-config.php 
 1357  cd wp-content
 1358  rm -fr plugins
 1359  sudo rm -fr plugins
 1360  sudo rm -fr themes
 1361  sudo ln -s /home/joe/bt-wp/themes 
 1362  sudo ln -s /home/joe/bt-wp/plugins
 1363  cd /etc/apache2/sites-enabled/
 1364  ls
 1365  vi bt
 1366  sudo service apache2 graceful
 1367  sudo vi /etc/hosts
 1368  cd /var/www/bt/
 1369  stat wp-content
 1370  chmod -0755 wp-content
 1371  chmod 0755 wp-content
 1372  sudo chmod 0755 wp-content
 1373  sudo chmod 0766 wp-content
 1374  sudo chmod 0777 wp-content
```
