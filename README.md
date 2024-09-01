# Local PlusStore
A local PlusStore API for PlusCarts (a custom node.js script for simple-web-server).

This local API doesn't support many features of the orignal PlusStore.
 - Search function
 - "Popular ROMs"
 - "Recently added ROMs"
 - "My Favourite ROMs"
 - "My Recently Played ROMs"
 - Text file reading
 - ZIP/tar file unpacking
 - High Score Club leaderboard
 - PlusCart chat
 - List of users online

Some of these feature might be added later, but most don't make sense in a local environment.

## Install
Download and install "simple-web-server" from here https://simplewebserver.org/

Create a new server with a "Folder Path" to your ROMs. This can also be your nextcloud PlusStore folder if you have a PlusStore account.

Server port must be set to "80". Activate "Accessible on local network" and "Enable .swshtaccess configuration files" (see Advanced Options).

Download "api.php" and ".swshtaccess" from this repository and place them in your ROMs root folder.

## Untested Feature
WiFi firmware update (FOTA) should work with a "firmware.bin" file in the ROMs root folder.
