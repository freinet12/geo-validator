GEO VALIDATOR

## SETUP
- Install PHP version 7.2+
- Install MYSQL (mysql  Ver 15.1 Distrib 10.4.11-MariaDB)
- Create Database: <br>
    <div>
	    CREATE DATABASE IF NOT EXISTS geo <br>
	    CHARACTER SET = 'utf8mb4' <br>
	    COLLATE = 'utf8mb4_unicode_ci';
    </div>

- Copy the contents of .env.example into a new file in the root app dir called .env
- Open up the .env file and update the following: <br>
	    DB_HOST=your_mysql_host_ip <br>
	    DB_PORT=3306 or whatever port mysql is running on <br>
	    DB_USERNAME=your_mysql_username <br>
	    DB_PASSWORD=your_mysql_password <br>

## Migrations
 - Run the following command: <br>
 <code> php artisan migrate </code>


## Endpoints

1) Create All 50 State Records <br>
	<code> {APP_URL}/api/states/createAll </code> <br>
	required fields: none <br>
    - returns: <br>
        - <code> All sates created successfully! </code>

2) Create City & Zip Records by Uploading a geo file <br>
	<code> {APP_URL}/api/createGeoRecords </code> <br>
	required fields: <br>
     - file (the geo file which has zip, city, state) <br>
     returns: <br>
        - <code> Done. </code>

3) Validate Provided Geo <br>
	<code> {APP_URL}/api/validateGeo </code> <br>
	- required params: <br>
        - <code> city </code> (city name) <br>
		- <code> state </code> (2 letter state code) <br>
	    - <code> zip </code> (5 digit zip-code) <br><br>
	example: <br>
    <code> {APP_URL}/api/validateGeo?city=stebbins&state=ak&zip=99671 </code> <br>
    - returns: <br>
        - <code>valid geo </code> (if the provided geo is valid) <br>
        - <code> invalid geo </code> (if the provided geo is invalid) <br>
        - <code> unable to validate geo </code> (if an error occured when trying to validate the provided geo) </br>
    
   
