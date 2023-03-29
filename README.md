# fingent

Fingent Global Solutions Machine Test

This project is using PHP as backend and MySql as Database.

1. Clone the project using the below code.

	git clone git@github.com:ojsudheesh/fingent.git

2. Create a table named "fingent"
	
	CREATE DATABASE `fingent`

3. Create the table named "requests"
	
	CREATE TABLE `requests` (id int(11), request_from text, request_time timestamp);


4. Opend the file `index.php` in your localhost and you can enter the number of api calls you want to hit.

5. In `/config/config.php`, requests processing per second (`MAX_REQUESTS_SECOND`) is set to handle only 10 requests per second (from the same IP address).