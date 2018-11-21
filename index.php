<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//testing comment
require_once(__DIR__.'/vendor/autoload.php');

if(getenv('ENV')!='staging')
{
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();
}


$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db_name = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');

$database_connection = pg_connect("host=$host port=$port dbname=$db_name user=$user password=$password");
if(!$database_connection)
{
	die('An error occured in database connection');
}
$created_on = date('Y-m-d G:i:s');
$result = pg_query($database_connection, "UPDATE visits SET visits=visits+1, created_on='$created_on';");
$fetch_results = pg_query($database_connection, "SELECT visits from visits;");
while ($row = pg_fetch_row($fetch_results)) {
    if(count($row))
    {
        echo 'You are visitor number <b>'.$row[0].'</b>!';
    }
    else
    {
        echo 'An error occured, please again later!';
    }
}

?>