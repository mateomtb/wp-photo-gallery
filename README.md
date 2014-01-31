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
* Log into wp-admin and activate all the plugins: http://www.scsun-news.com/wp-admin/plugins.php
* Go to http://www.scsun-news.com/wp-admin/admin.php?import=wordpress and import the export.xml file at ``dev/export.xml``
