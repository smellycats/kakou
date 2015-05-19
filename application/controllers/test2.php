<?php  

$user = 'dsmall';
$passwd = 'dsmall';
$dsn = 'oci:dbname=oradb';
$dbh = new PDO($dsn, $user, $passwd);

  $sql = 'SELECT * FROM example';
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $result = $sth->fetchAll();

echo "<pre>";
print_r($result);

?>