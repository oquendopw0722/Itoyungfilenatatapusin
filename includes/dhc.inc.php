<?php

$dsn = "mysql:host=localhost;dbname=myfirstdatabase";    
$dbusername = "root";
$dbpassword = "";

try {
  $pdo = new PDO($dsn, $dbusername, $dbpassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo "Connection Failed: " . $e->getMessage();
}



/* DSN - data source name

mysql:host = the host name
dbname = name of the database being connected

3 ways to connect database

mysql - bad and obsolete

mysqli - mysql improved - the new way

pdo - php data objects
-another way to connect to database, more flexible
can apply sql lite or other database

TRY CATCH - running PDO


*/