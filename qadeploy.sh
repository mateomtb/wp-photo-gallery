#!/bin/sh
#synch current repo plugins and theme directories to dfm-ssp-qa.medianewsgroup.com
rsync -vaz themes/ /app/wordpress/mediacenter-national/wp-content/themes
rsync -vaz plugins/ /app/wordpress/mediacenter-national/wp-content/plugins --exclude-from=rsync_exclude.txt
