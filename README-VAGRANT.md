1. Get the most-recent virtualbox, https://www.virtualbox.org/wiki/Downloads
1. Get the most-recent vagrant, http://www.vagrantup.com/downloads.html
1. Install the vagrant-hostsupdater plugin with `vagrant plugin install vagrant-hostsupdater`
1. Install the vagrant-triggers plugin with `vagrant plugin install vagrant-triggers`
1. Clone or extract the Varying Vagrant Vagrants project into a local directory, probably in your ~ or your work dir: `git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vagrant-local`
1. `cd vagrant-local; vagrant up; vagrant ssh`
1. Copy the contents of this shell script into your home directory on vagrant (you'll have to do this with a web browser because you won't have permissions to see it *yet* on your vagrant box), set its permissions so it can execute, and then run it: https://github.com/dfmedia/media-center/blob/master/helpstuff/vvv-init.sh
1. While the script runs you'll have to do a couple more setup tasks, which the script will guide you through, such as adding the ssh key for this new environment to your github account. 
1. The script will guide you through editing your ~/media-center/.git/config to point to your fork of the repo, and adding your user details to the git global config. To get your individual branches you'll have to git checkout -b [branchname] origin/[branchname] gets the branches you're working on yourself down onto your computer.
1. You're done! Open http://local.wordpress.dev/ and you've got your wordpress.

## Notes
* Access the server via the command line with `vagrant ssh` from your vagrant-local directory.
* Power off the box with `vagrant halt` and turn it back on with `vagrant up`.
* All database usernames and passwords for WordPress installations included by default are wp and wp.
* All WordPress admin usernames and passwords for WordPress installations included by default are admin andpassword.

### Visit any of the following default sites in your browser:
* http://local.wordpress.dev/ for WordPress stable
* http://local.wordpress-trunk.dev/ for WordPress trunk
* http://src.wordpress-develop.dev/ for trunk WordPress development files
* http://build.wordpress-develop.dev/ for the version of those development files built with Grunt
* http://vvv.dev/ for a default dashboard containing several useful tools

### More
* Read the VVV README (the repo this environment is based off of) here: https://github.com/Varying-Vagrant-Vagrants/VVV
* Vagrant site: http://vagrantup.com
