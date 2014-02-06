# Heck yes I want a dev environment.
Get a dev environment set up! Yes, you! 

* Install wordpress. I installed it to /var/www/bt, your setup may differ. Take care of the wp-config and database setup details.
* Go into wp-content and delete both your themes and plugins dir.
* Symlink themes to wp-content/themes. i.e. if you're in wp-content, ``ln -s /full/path/to/themes`` and ```ln -s /full/path/to/plugins``` 
* Do the same for plugins.
* While you're at it you'll need the submodules. ``git submodule init; git submodule update`` from the repo root.
* In your hosts file, point www.scsun-news.com to localhost.
* Use the apache virtual host file in the dev folder (may need to adjust wordpress directory paths) to point your webserver to that domain. Put that file in your ``/path/to/apache2/sites-enabled/`` .
* Restart apache. On linux that's ``sudo service apache2 restart``
* Change the permissions on your wp-content directory. Either change the owner to the same owner of your webserver processes, or run ``sudo chmod 0777 wp-content`` from the wordpress root.
* Edit your wp-config.php file. It's in the wordpress root. It will ask you for database information...
* Create a database for your blog. Name it whatever you want. There are many ways to create a database, hopefully you know one.
* Log into wp-admin and activate all the plugins: http://www.scsun-news.com/wp-admin/plugins.php
* Also (visit the themes page)[http://www.scsun-news.com/wp-admin/themes.php] and make sure the Bartertown theme is active.
* Go to http://www.scsun-news.com/wp-admin/admin.php?import=wordpress and import the export.xml file at ``dev/export.xml``

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
