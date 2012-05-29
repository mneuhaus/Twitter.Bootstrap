#!/bin/bash

# This script temporarily clones remote's Assetic repository
# and copies parts of it into the appropriate FLOW3's package's
# directories.

BOOTSTRAP_REPOSITORY="git://github.com/twitter/bootstrap.git"

echo Twitter Bootstrap file checkout script
echo

if [ ! -d "Classes" -o ! -d "Scripts" -o ! -d "../Twitter.Bootstrap" ]; then
	echo Make sure you run this from the Assetic package\'s root directory!
	echo
	exit 1
fi

git clone $BOOTSTRAP_REPOSITORY ./_tempclone

echo Copying files
cp -R ./_tempclone/LICENSE ./Meta
cp -R ./_tempclone/img ./Resources/Public/Master
cp -R ./_tempclone/js ./Resources/Public/Master
cp -R ./_tempclone/less ./Resources/Public/Master
cp -R ./_tempclone/docs/* ./Documentation
cp -R ./_tempclone/README.md ./Documentation
cp -R ./_tempclone/package.json ./Meta


echo Removing temporary directory
rm -rf ./_tempclone

echo Generating Assets.yaml
php ./Scripts/generate-assets.php

echo Done.