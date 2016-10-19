<?php

// This is the hostname or IP of the database server.
// Since we are using MySQL running on the same computer as your
// PHP code, you would use either 127.0.0.1 or localhost.  Both
// are reserved in the IP protocol to refer to this system (the local computer).
$db_hostname = '127.0.0.1';

// A username is required to connec to MySQL.  Be default, the root
// user is the only user.  If you install XAMPP with default options,
// you can use the root user.
$db_username = 'root';

// A password may be required for the user.  By default, XAMPP does
// not set a password for the root user.  If you are in the database
// class and installed MySQL separatly from XAMPP, you may have a
// password set.  If that is the case, set it here.
$db_password = '';

// Typically you want to specify what database to use.
// For this PHP script, we will use the `classicmodels` database.
// You must import this database into MySQL first using
// MySQL workbench.  See the README for this repo in GitHub.
$db_database = 'classicmodels';

// The DSN (Data Source Name) used to connect to the MySQL database using PDO
$dsn = "mysql:host=$db_hostname;dbname=$db_database";

try {
    // Use PDO to create a database handler.
    //   http://php.net/manual/en/ref.pdo-mysql.connection.php
    $dbh = new PDO($dsn, $db_username, $db_password);

    // Make sure that PDO will throw exceptions if there is an error.
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "Fatal error trying to connect to the MySQL database: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
    // exit non-zero since we encountered an error
    exit(1);
}

try {
    // For your query, you will need to join the customers and employees
    // tables together.
    $query_result = $dbh->query("SELECT your query here");

    // Fetch each row of the query result as an associative array.
    while($row_array = $query_result->fetch()) {
        // Your output goes here
    }
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}
