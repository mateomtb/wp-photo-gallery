#!/bin/bash
# Yes we're using bash. Yes its extension is .sh
REPO_SSH_URL="git@github.com:dfmedia/media-center.git"
COL_HIGHLIGHT="\x1b[35;01m"
COL_RESET="\x1b[39;49;00m"
COL_HIGHLIGHT=""
COL_RESET=""

# Create a pub eky, if it's not there.
echo "$COL_HIGHLIGHT[[SSH]]"
if [ ! -f ~/.ssh/id_rsa.pub ]
then
	cd ~/.ssh; ssh-keygen; cat ~/.ssh/id_rsa.pub
	echo -e "$COL_RESET Hit enter after you've added your pub key to your git account here:\nhttps://github.com/settings/ssh"
	read whatever
else
	echo -e "Looks like you already have a ssh key set up.\nWe're assuming you've already added it to your git account here https://github.com/settings/ssh"
fi

cd ~

# Clone the repo, if it's not there already
echo "$COL_HIGHLIGHT[[REPO]]"
if [ ! -d media-center ]
then
	echo "$COL_RESET Cloning the repo"
	git clone $REPO_SSH_URL
	echo "Change repo path to your fork"
	vim ~/media-center/.git/config
	echo -e "Pulling down all your remote branches.\nTo use one of your remote branches check it out like so:\ngit checkout -b [branchname] origin/[branchname]"
	cd ~/media-center/; git pull -a
	echo "What's your github username?"
	read gituser
	git config --global user.name "$gituser"
	echo "What's your github account email?"
	read gitemail
	git config --global user.email "$gitemail"
	cd ~/media-center; git submodule init; git submodule update
else
	echo -e "The repo directory already exists, and should contain the repo.\nIf not, delete it and run Vagrant provisioning again."
fi


cd /srv/www/wordpress-default/wp-content
rm -fr themes; rm -fr plugins
ln -s ~/media-center/themes
ln -s ~/media-center/plugins

# Database
cd ~/media-center/helpstuff
mysql -u root --password=root wordpress_default < vvv.sql 

# wp-config
# Kill the opening <?php line and replace with our config, if we haven't yet.
if [[ `grep WP_CACHE wp-config-vvv.php` == *WP_CACHE* ]]
then
	cd /srv/www/wordpress-default
	tail -n +2 /srv/www/wordpress-default/wp-config.php > ~/tmp
	cat ~/media-center/helpstuff/wp-config-vvv.php ~/tmp >> /srv/www/wordpress-default/tmpconfig.php
	mv tmpconfig.php wp-config.php
fi

echo -e "Done! Go to http://local.wordpress.dev/ and see how it all worked out."
