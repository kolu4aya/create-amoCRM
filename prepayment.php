<?
include('auth.php');
auth();
include('requestamo.php');

$data='filter[statuses][0][pipeline_id]=2094802&filter[statuses][0][status_id]=30157468';
$method='v4/leads';
$arResponse=request($data,$method);
// echo "<pre>";
// var_dump($arResponse);
// echo "</pre>";
$sum=0;
for ($i=0; $i<count($arResponse['_embedded']['leads']); $i++){
  $sum+= $arResponse['_embedded']['leads'][$i]["custom_fields_values"][4]["values"][0]["value"];
}
echo "Предоплат: <br>";
echo $sum;
?>