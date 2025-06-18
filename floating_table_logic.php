<?php
session_start();

// Edit option is used
if(isset($_GET['edit_table']))
{
    $_SESSION["edit_table_mode"] = true;
}
//Freeze option is used
if(isset($_GET['freeze_table']))
{
    unset($_SESSION["edit_table_mode"]);
}

// Reset session if reset button is clicked
if (isset($_GET['reset_table'])) {
    unset($_SESSION['floating_table']);
    // Remove only 'reset_table' from the query string
    $query = $_GET;
    unset($query['reset_table']);
    unset($_SESSION["visited"]);
    $queryString = http_build_query($query);
    $redirectUrl = strtok($_SERVER["REQUEST_URI"], '?') . ($queryString ? "?" . $queryString : "");
    header("Location: $redirectUrl");
    exit();
}

if(isset($_GET["home_page"])) header("Location: index.php");

// Handle increment or decrement
$incval=100;
if(isset($_SESSION["lastmoney"])) $incval=100*$_SESSION["lastmoney"];
else $incval=$_GET["money"]*100;
if (isset($_GET['action'], $_GET['col'], $_GET['row'])) {
    $row = (int)$_GET['row'];
    $col = (int)$_GET['col'];
    if (isset($_SESSION['floating_table'][$row][$col])) {
        $current = (int)$_SESSION['floating_table'][$row][$col];
        if ($_GET['action'] === 'inc') {
            $_SESSION['floating_table'][$row][$col] = $current + $incval;
        } elseif ($_GET['action'] === 'dec') {
            $_SESSION['floating_table'][$row][$col] = $current - $incval;
        }
    }
    // Remove action, row, and col from query string and redirect
    $query = $_GET;
    unset($query['action'], $query['row'], $query['col']);
    $queryString = http_build_query($query);
    $redirectUrl = strtok($_SERVER["REQUEST_URI"], '?') . ($queryString ? "?" . $queryString : "");
    header("Location: $redirectUrl");
    exit();
}

// Initialize the floating table data if not already set
$_SESSION['floating_table_headers'] = ["Player 1", "Player 2", "Player 3", "Player 4"];
if (!isset($_SESSION['floating_table'])) {
    $sa=[];
    foreach($_SESSION['floating_table_headers'] as $person) {array_push($sa,'0');};
    $_SESSION['floating_table'] = [$sa,];
}

if(isset($_GET["money"])) $_SESSION["lastmoney"]=$_GET["money"];
// Example: Add a new row from PHP code elsewhere
// $_SESSION['floating_table'][] = ['New 1', 'New 2', 'New 3'];
?>
