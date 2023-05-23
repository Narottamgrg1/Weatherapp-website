<?php

$mySql = new mysqli('localhost', 'root', '', 'weather');

$Table = "CREATE TABLE IF NOT EXISTS Bradford (
    city varchar(255),
    temp int,
    humidity int,
    wind float(10,3),
    date_time DATETIME DEFAULT NOW()
)";

$query = "SELECT *
FROM Bradford
WHERE city='{$_GET['city']}'
AND date_time >= DATE_SUB(NOW(), INTERVAL 1800 SECOND)
ORDER BY date_time DESC limit 1";

$result = $mySql->query($query);

if ($result->num_rows == 0) {

    $data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q={$_GET['city']}&appid=24f49d886f5843bc2a3d397f6bbd9321&units=metric");

    $decode_data = json_decode($data);
    $dateT=date_create(null,timezone_open("Asia/Kathmandu"));
    $date_time= date_format($dateT,"Y-m-d H:i:s");
    $city = $decode_data->name;
    $temp = $decode_data->main->temp;
    $humidity = $decode_data->main->humidity;
    $wind = $decode_data->wind->speed;

    $insert = "INSERT INTO Bradford
   VALUES ('$city','$temp','$humidity',
   '$wind', '$date_time' )";

    $mySql->query($insert);
}

$sql = "SELECT *
FROM Bradford
WHERE city='{$_GET['city']}'
ORDER BY date_time DESC limit 1";

$jason = $mySql->query($sql);
$row = $jason->fetch_assoc();
print json_encode($row);
$jason->free_result();
$mySql->close();

?>