This systems allows a user to create an account, and then read/edit data from an inventory database table from various web pages.

Installation Requirements:
A webserver and a mySQL server containing the information from SchemaAndTables.sql (Xampp recommended)

First Time Usage Instructions:
Install XAMPP and then run it. Start both Apache and MySQL, then in a web browser go to http://localhost/phpmyadmin/ and
click the import tab. Import the file SchemaAndTables.sql and click Go, then import the file DummyData.sql and click Go.
Open a new tab and go to the system's home page at http://localhost/nursinginventorysystem/ and login with the username
"admin" and the password "1234" for an admin user or use the username "Craig" and the password "1234" for a standard user.
You now have full access to the system.

Notes:
If when adding something to the system, a non-integer is put in an integer-only 
column, that value will be ignored and a 0 will be inserted into the database in its place.

The home page is on http://localhost/nursinginventorysystem/