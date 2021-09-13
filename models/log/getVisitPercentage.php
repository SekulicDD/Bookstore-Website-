<?php

header('Content-Type: application/json');

$file = fopen('../../data/log.txt','r');
$arr=[];
$arrTime=[];
$time=date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$time= strtotime($time);


while ($line = fgets($file)) {   
    $time2=substr($line,strrpos($line,"t")+1);
    $time2=strtotime($time2);
    $difference = round(abs($time - $time2) / 3600,2);
    if($difference<=24){
        array_push($arr,substr($line,0,strpos($line,".php")));
    }

}

fclose($file);

$arr=array_count_values($arr);

echo json_encode($arr);










