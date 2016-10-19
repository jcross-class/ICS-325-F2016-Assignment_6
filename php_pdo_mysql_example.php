<?php

// This is the hostname or IP of the database server.
// Since we are using MySQL running on the same computer as your
// PHP code, you would use either 127.0.0.1 or localhost.  Both
// are reserved in the IP protocol to refer to this system (the local computer).
$db_hostname = '127.0.0.1';

// A username is required to connect to MySQL.  Be default, the root
// user is the only user.  If you install XAMPP with default options,
// you can use the root user.
$db_username = 'root';

// A password may be required for the user.  By default, XAMPP does
// not set a password for the root user.  If you are in the database
// class and installed MySQL separately from XAMPP, you may have a
// password set.  If that is the case, set it here.
$db_password = '';

// Typically you want to specify what database to use.
// For this PHP script, we will use the `examples` database.
$db_database = 'examples';

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
    // Perform a SELECT query.
    $query_result = $dbh->query("SELECT * from `people`");

    // Fetch each row of the query result as an associative array.
    //
    // Notice that the result set is printed in alphabetical order of last name, first name
    // without an ORDER BY clause.  This is the case because we defined the primary key of
    // the table to be (lname, fname).
    while($row_array = $query_result->fetch()) {
        echo $row_array['fname'] . " " . $row_array['lname'] . " likes " . $row_array['color'] . ", " .
            $row_array['food'] . ", " . $row_array['game'] .", and " . $row_array['lang'] . ".\n";
    }

    // Record the number of rows in the `people` table.
    //
    // Since we fetched all the rows in the `people` table,
    // the number of rows in the result set is the number of rows
    // in the `people` table.
    $number_people = $query_result->rowCount();
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}

echo "\nThere are $number_people rows in the `people` table.\n\n";

// select all the color column values, group them by color value, and count how many
// of each value is present.  Finally, order the results in descending order based on the
// count of each color.
try {
    $query_result = $dbh->query("SELECT `color`, COUNT(`color`) AS `colorTotal`
                                   FROM `people` GROUP BY `color` ORDER BY COUNT(`color`) DESC");
    echo "Color\n";
    while($row_array = $query_result->fetch()) {
        printf("    %.2f%% %s\n", ($row_array['colorTotal'] / $number_people) * 100, $row_array['color']);
    }
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}

try {
    $query_result = $dbh->query("SELECT `food`, COUNT(`food`) AS `foodTotal`
                                   FROM `people` GROUP BY `food` ORDER BY COUNT(`food`) DESC");
    echo "Food\n";
    while($row_array = $query_result->fetch()) {
        printf("    %.2f%% %s\n", ($row_array['foodTotal'] / $number_people) * 100, $row_array['food']);
    }
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}

try {
    $query_result = $dbh->query("SELECT `game`, COUNT(`game`) AS `gameTotal`
                                          FROM `people` GROUP BY `game` ORDER BY COUNT(`game`) DESC");
    echo "Game\n";
    while($row_array = $query_result->fetch()) {
        printf("    %.2f%% %s\n", ($row_array['gameTotal'] / $number_people) * 100, $row_array['game']);
    }
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}

try {
    $query_result = $dbh->query("SELECT `lang`, COUNT(`lang`) AS `langTotal`
                                          FROM `people` GROUP BY `lang` ORDER BY COUNT(`lang`) DESC");
        echo "Lang\n";
        while($row_array = $query_result->fetch()) {
            printf("    %.2f%% %s\n", ($row_array['langTotal'] / $number_people) * 100, $row_array['lang']);
        }
} catch (PDOException $e) {
    // We are specifically catching a PDOException as those are the ones we expect.
    //  http://php.net/manual/en/class.pdoexception.php
    echo "There is a problem with the select query: " . $e->getMessage() . "\n";
    echo "Any extended information: " . $e->errorInfo . "\n";
}


// We're all done with the MySQL connection so close it.
// To do that, we set the PDO database handler to null so PHP will garabage collect and close the PDO connection.
// Note that in this case, this isn't necessary since the PHP script is done and the connection
// will be closed by PHP anyway.
$dbh = null;