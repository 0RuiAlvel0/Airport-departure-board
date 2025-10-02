# Airport Departure Board

![Preview](https://github.com/commacmms/Airport-departure-board/blob/main/airport.png?raw=true)

## NOTES
- airlabs.co now makes you go through a verification process in order to approve your free API key. Tell them that you are using this repo and that
you will not be making many requests. If you can and see the value do consider to become a paid customer.

## Overview
This project is designed to run on a system with Apache and PHP. It has been tested with PHP 8.3 on Linux but should work with other configurations. Good results have also been reported using Lighttpd with PHP 7.3. Ensure you have `php-curl` installed. [See here how to install it](https://stackoverflow.com/questions/6382539/call-to-undefined-function-curl-init).

### API Key
To use this project, you need an API key from [AirLabs](https://airlabs.co/). Create a `.env` file and place it in the root folder. Copy the contents of `.env.template` into it and insert your API key into `.env`.

#### Free API Limitations
The free version of the API allows up to 1,000 requests per month. You can request double that (2,000 requests per month) by following the instructions in the automated email you receive upon registration. With 2,000 requests per month:
- You can make **64 requests per day** in a 31-day month.
- This equates to **2 requests per hour** or **1 request every 30 minutes**.

### Configuration
Once you copy the files to your root folder, navigate to `base.php` to see the application in action.

You can configure the number of rows displayed in the arrivals and departures lists by editing the top of the `base.php` file. This allows you to adjust the results list to fit your screen size.

---

## Installation
1. Clone the repository:
   ```
   git clone https://github.com/commacmms/Airport-departure-board.git
   ```
2. Navigate to the project directory:
   ```
   cd Airport-departure-board
   ```
3. Install dependencies using Composer:
   ```
   composer install
   ```
4. Create a `.env` file in the root directory:
   - Copy the contents of `.env.template` into `.env`.
   - Add your API key to the `api_key` field.
   - sudo chmod 644 <path to your file>/.env

5. Ensure the `settings` file is writable by the web server:
   ```
   sudo chown www-data:www-data settings
   ```

6. Open `base.php` in your browser to view the application.

---

## Contributor Notes
### Additional Comments by [corbelr](https://github.com/corbelr) (OLD)
This fork includes many new features and improvements. Please note:
- This code does **NOT** work on a computer running Lighttpd 1.4/PHP 7.4. Use Apache 2/PHP 7.4 for best results.
- Since the Apache 2 process runs under the `www-data` identity, you must change the owner/group of the directory containing the code (e.g., `adb`). Run the following commands in the terminal:
   ```
   cd /var/www/html
   sudo chown -R www-data:www-data ./adb
   ```

---

## Have Fun!
Feel free to report bugs, submit new features, or fork this repository to contribute to the project!