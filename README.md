# LearningPHP
This is my first attempt at learning and using php for server-side scripting

I have created a working registeration form that accepts some basic information from the user and stores it in a local MySQL database. The pages are deployed using a local Apache2 HTTP server on a Linux Ubuntu 14.04 platform.

The form validates user inputs on the html page and stores the data in a database named UserAccounts.

To use this code you need to fill out the appropriate username and password fields in the php files, first.
This has to be followed by running the createDB.php by hitting localhost/createDB.php in the browser window.

After this you can access the registeration form by hitting localhost/reg_form.html

NOTE: You need to first copy the files to the /var/www directory on a linux machine for the server to successfully deploy the pages
