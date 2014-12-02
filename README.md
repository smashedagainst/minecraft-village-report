minecraft-village-report
========================

php webpages for Minecraft 1.8+ server status and parsing of NBT file villages.dat.

##Install
1. Unzip in a webfolder.
2. Edit the $world_dir variable in the 3 `villages*php` files.
3. Visit villages.php on your minecraft server's web server.
4. Have some of the guess-work behind doors and villages lifted.


##Usage
1. The minecraft server file `data/villages.dat` updates with the currently
loaded villages roughly once a minute.
2. Every 7 seconds, the `villages.php` page refreshes the container div
by loading `villages_container.php`.
3. To help when placing or removing doors, the boxes with villages in
them flashes green upon every reload. This helps you to not rush.
