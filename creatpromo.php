<?
// include('auth.php');
// auth();
// include('requestamo.php');
// include('editamo.php');
// error_reporting(-1);
// $method='v4/contacts';
// $arParams='limit=250&with=catalog_elements&page=';
// $page=14;
// $arParams.=$page;
// $arResponse=request($arParams,$method);
// $listcontact=[];
// $listcontact=array_merge($listcontact,$arResponse['_embedded']['contacts']);
// echo '<pre>';
// var_dump($listcontact);
// echo '<pre>';
$chars='ABCDEFGHIJKLMNOPQRSTUVW';
// for ($i=0; $i<count($listcontact); $i++){
    $promo='';
    for ($j=0; $j<8; $j++){
      if(rand(0,1)){
         $promo.=$chars[rand(0,(strlen($chars)-1))] ;
      } else {
         $promo.=rand(0,9) ; 
      }
      
    }
   echo  $promo.'<br>';
//     $idthiscontact=$listcontact[$i]['id'];
// $method='v4/contacts/'.$idthiscontact;
//     $datacontacts=array(
//         "custom_fields_values"=> array(array(
//                 "field_id"=> 480477,
//                 "values"=> array(
//                     array(
//                         "value"=> $promo
//                     )
//                 )
//             )
//             )
//         );
//         $reques=edit($datacontacts,$method);
//         echo $reques;
//         sleep(0,2);
//  }
?>