This is a reminder for users who want to install 'Airport Departure Board' (by Ruy Alves) on their computer.
The code you'll find on this fork is an evolution, many features have been added.
NOTE : this code does NOT work on a computer that runs Lighttpd 1.4/PHP 7.4. Use Apache 2/PHP 7.4 for best results.

Feel free to report bugs and submit a new version with new features.

Since the Apache 2 process runs under 'www-data' identity, it is necessary to change owner/group of the directory (let's say 'adb') which contains the code. You do this in a terminal like this :
cd /var/www/html
sudo chown -R www-data:www-data ./adb
This allows the settings.php page to modify the 'settings' file to reflect the airport chosen by the user. If the 'settings' file were owned by root, it would be impossible for the Apache 2 process to update this file.

It is a good idea, for those who want to work on the code locally, to put their normal user (pi) in the www-data group. Just do this in a terminal :
sudo usermod -a -G www-data pi
Close the session, then re-open it.

Have fun !

