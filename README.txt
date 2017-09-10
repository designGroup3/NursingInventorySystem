This systems allows a user to create an account, and then read/edit data from an inventory database table from various web pages.

Installation Requirements:
A webserver and a mySQL server containing the information from SchemaAndTables.sql (Xampp Recommended)

Notes:
If when adding something to the system, a non-integer is put in an integer-only 
column(Inventory.QuantityOrdered, Inventory.QuantityStored), that value will be ignored and a 0
will be inserted into the database in its place.

The home page is on http://localhost/loginpage/