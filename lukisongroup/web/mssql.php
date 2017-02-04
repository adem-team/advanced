<?php
$link = mssql_connect('192.168.1.2','sa','rahasia');

/* if (!$link){
	die('Unable to connect!');
}else{
	print_r('connect');
} */
    

/* if (!mssql_select_db('SSS', $link))
    die('Unable to select database!');

$result = mssql_query('SELECT * FROM ms');

while ($row = mssql_fetch_array($result)) {
    var_dump($row);
}

mssql_free_result($result);
print_r('as');  */
?>