# Airport departure board
This was made to run on a system with Apache and PHP. I used php 8 and linux but should run with other options. Good operation has also been reported with lighhttpd and php 7.3. Ensure you have php-curl installed (see here how to install it: https://stackoverflow.com/questions/6382539/call-to-undefined-function-curl-init)

Don´t forget to get your https://airlabs.co/ API key and insert it in api.php.

Free version of API requests limit per month is 1000 but you can request double that by email (the procedure is explained on the automated email you receive upon registration). With 2000 requests per month you have to control yourself: in the worst case scenario (which is a 31-day month) you can only make 64 requests per day or 2 requests per hour or 1 request every 30 minutes.

Once you copy these files to your root folder, you can go to base.php and something should show up. 

You can set the number of rows that show up on the arrivals and departures lists at the top of the base.php file. This will allow you to set the results list to the size of your screen.

The selection of the airport on the settings file is not done yet. Feel free to fork this repository and do it for the community, me included.

see here for more information: https://supertechman.blogspot.com/2022/06/raspberry-pi-based-airport-arrivals-and.html
