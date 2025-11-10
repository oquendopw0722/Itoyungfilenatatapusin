9 lines
<?php
require_once "includes/dhc.inc.php";
echo "Connection to myfirstdatabase successful!";
try {
    $stmt = $pdo->query("SELECT 1 FROM users LIMIT 1");
    echo " Table exists!";
} catch (PDOException $e) {
    echo " Table error: " . $e->getMessage();
}
