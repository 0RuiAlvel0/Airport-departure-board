# Airport departure board

![alt text](https://github.com/commacmms/Airport-departure-board/blob/main/HowItLooksResized.jpg?raw=true)

This was made to run on a system with Apache and PHP. I used php 8 and linux but should run with other options. Good results have also been reported with lighhttpd and php 7.3. Ensure you have php-curl installed (see here how to install it: https://stackoverflow.com/questions/6382539/call-to-undefined-function-curl-init)

Don´t forget to get your https://airlabs.co/ API key and insert it in api.php.

Free version of API requests limit per month is 1000 but you can request double that by email (the procedure is explained on the automated email you receive upon registration). With 2000 requests per month you have to control yourself: in the worst case scenario (which is a 31-day month) you can only make 64 requests per day or 2 requests per hour or 1 request every 30 minutes.

Once you copy these files to your root folder, you can go to base.php and something should show up. 

You can set the number of rows that show up on the arrivals and departures lists at the top of the base.php file. This will allow you to set the results list to the size of your screen.

~~The selection of the airport on the settings file is not done yet. Feel free to fork this repository and do it for the community, me included.~~
Additional comments by contributor https://github.com/corbelr after his amazing contribution to the project:

--START
This is a reminder for users who want to install 'Airport Departure Board' (by Ruy Alves) on their computer.
The code you'll find on this fork is an evolution, many features have been added.
NOTE : this code does NOT work on a computer that runs Lighttpd 1.4/PHP 7.4. Use Apache 2/PHP 7.4 for best results.

Feel free to report bugs and submit a new version with new features - you can do that here and/ or at corbelr's repository.

Since the Apache 2 process runs under 'www-data' identity, it is necessary to change owner/group of the directory (let's say 'adb') which contains the code. You do this in a terminal like this :
cd /var/www/html
sudo chown -R www-data:www-data ./adb
This allows the settings.php page to modify the 'settings' file to reflect the airport chosen by the user. If the 'settings' file were owned by root, it would be impossible for the Apache 2 process to update this file.

It is a good idea, for those who want to work on the code locally, to put their normal user (pi) in the www-data group. Just do this in a terminal :
sudo usermod -a -G www-data pi
Close the session, then re-open it.

Have fun !
--END


see here for more information: https://supertechman.blogspot.com/2022/06/raspberry-pi-based-airport-arrivals-and.html
