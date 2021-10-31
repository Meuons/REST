# REST

This is a REST webservice built with object oriented php and with complete CRUD (create, read, update, delete) functionality. It takes data from a database and returns it in JSON format. It serves as a connection between a database and the application connected to the service. 

## Activation

The web service is activated by uploading the catalog to a webhost and using the address of the rest.php file as an API. When you connect it is possible to read data from the database and to send data to it.

## Info

The database to which the web service is connected to can be changed by typing in the details of the database in the property variables in the database.php file.

This web service protects the database against SQL injections and html tags containing harmful code thanks to the strip_tags and real_escape_string functions in the course.php file. 

It is also has functionality for password protection to prevent unauthorized people from making changes to the database it is connected to.

The web service can be accessed from all domains which menas it is also possible to use it on and access it from a local server.

Make sure that the web server you decide to host the catalog on supports the version of php that the code uses as this can cause errors otherwise. 

## Database setup

For safety reasons the connection credentials to the database have been removed from the database.php file in this repository. 
You have to fill in the credenitals to the database you want to connect to where the comments in the file tells you to put them.

The tables should be created according to the following diagram https://imgur.com/K6YcUMd in order to work with the web service.

The datatypes for all columns should be VARCHAR except the IDs which should be INT and auto increment.
