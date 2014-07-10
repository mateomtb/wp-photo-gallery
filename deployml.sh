# Used to update the themes. 
# Now takes arguments in case we have a plugin.

SCP=0
# What arguments do we pass?
while [ "$1" != "" ]; do
	case $1 in
		-p | --plugin ) shift
			PLUGIN=$1
			SCP=1
			;;
	esac
	shift
done

cd /home/mleyba/Repos/media-center 
if [[ "$SCP" > 0 ]]; then
	echo "Log in to push plugin $PLUGIN to production"
	scp -r plugins/$PLUGIN mcprod:/app/wordpress/mediacenter-national/wp-content/plugins/
fi

echo "Log in to push changes to main-site theme (mcenter), otherwise just cancel"
scp -r themes/mcenter mcprod:/app/wordpress/mediacenter-national/wp-content/themes/
echo "Log in to push changes to mobile theme (ajaxit)"
scp -r themes/ajaxit mcprod:/app/wordpress/mediacenter-national/wp-content/themes/

