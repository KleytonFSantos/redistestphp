<?php
require './vendor/autoload.php';


$redis = new Predis\Client();
$cachedEntry = $redis->get('name');


 if($cachedEntry)
{
    echo "Displaying data from Redis Cache <br>";
    echo $cachedEntry;
    exit();   
}
else 
{
    $conn = new mysqli("localhost:3306", "root", "1234", "drnahora_db");
    $sql = "SELECT name FROM `qualitare_drnahora_medicos`; ";
    $result = $conn->query($sql);

    echo "From Database: <br>";

    $temp = '';
    while($row = $result->fetch_assoc())
    {
        echo '<strong style="color:purple;">' . $row['name'] . '</strong><br>';

        $temp .='<strong style="color:green;">' . $row['name'] . '<br> </strong>';
    }
  

    $redis->set('name', $temp);
    $redis->expire('name', 10);

}

?>