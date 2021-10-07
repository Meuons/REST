# REST

This is a REST webservice built with object oriented php and with complete CRUD (create, read, update) functionality. It takes data from a database and returns it in JSON format. It makes it possible to access a database with JavaScript using fetch API. 

## Activation

The web service is activated by uploading the catalog to a webhost and using the address of the rest.php file as an API. When you connect it is possible to read data from the database and to send data to it.

## Info

The database to which the web service is connected to can be changed by typing in the details of the database in the property variables in the database.php file

This web service protects the database against SQL injections and html tags containing harmful code thanks to the strip_tags and real_escape_string functions in the course.php file. 

The web service can be accessed from all domains which menas it is also possible to use it on and access it from a locla server

Make sure that the web server you decide to host the catalog on supports the version of php that the code uses as this can cause errors otherwise. 

## Links

http://studenter.miun.se/~mama2006/moment5/rest/rest.php this the address where the web service is currently hosted 

