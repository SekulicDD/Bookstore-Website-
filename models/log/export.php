<?php
require_once '../../config/config.php';

$path="C:\Users\zabor\Desktop\log.xls";

$data=$_POST["data"];
$data=json_decode($data);
$data=json_decode(json_encode($data), true);

$excel=new COM("excel.application") or Die("Error connecting to excel");
$workbook=$excel->Workbooks->Add();
$worksheet=$workbook->Worksheets('Sheet1');

$polje=$worksheet->Range("A1");
$polje->activate;
$polje->Value="Page";

$polje=$worksheet->Range("B1");
$polje->activate;
$polje->Value="Times visited";

$polje=$worksheet->Range("C1");
$polje->activate;
$polje->Value="Precentage";


for ($i=0; $i <count($data) ; $i++) {
    $row=$i+2;
    for ($j=0; $j <count($data[$i]) ; $j++) { 
        $col=chr($j+65);
        $polje=$worksheet->Range($col.$row);
        $polje->activate;
        $polje->Value=$data[$i][$j];
    }
}


$workbook->SaveAs($path,-4143);
$workbook->Save();
$workbook->Saved=true;
$workbook->Close;

unset($worksheet);
unset($workbook);

$excel->Workbooks->Close();
$excel->Quit();

unset($excel);


