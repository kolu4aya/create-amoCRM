<?
// $confirmationToken = '521538fd';
// $secretKey = 'aa1122qqzz';
// $token = '750c3ab3b19c1a825031031fa6769f8d781fa4bcfbc5f9177ec77d49f98be594f5bbbdf39f00c5dc0ba77';
$confirmationToken = '0a3dfc20';
$secretKey = 'aa1122qqzz';
$token = '72df94cc1ed2428185fd518fd8b250a1c9d6770d36344c04d770d2837e7806dbd3d1d8cff703219280e00';

// if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
//     return;

$data = json_decode(file_get_contents('php://input'));
if ($data->type=='confirmation') {
    
        echo $confirmationToken;
    
}else {
include('auth.php');
auth();
include('createamo.php');
include('requestamo.php');
include('editamo.php');
error_reporting(-1);
global $str,$area, $type, $discipline, $topic, $ap, $typeap, $comment, $date;
//if ($data->secret =='e5e360ffc5f28b286183ea32aa46bc9683a0bd30935207' || $data->secret =='4d6f5b2cf0ada0036f079a04b59acc605eb21e89513784'  || $data->secret =='2b2d693bc7c262d47ae5b0343e10f47f7617ec9c'  || $data->secret =='ffc54fe08eca14f27b3c07db01679ccd0859d045907196' || $data->secret =='81f3572099a5110f3858cd183de75047c36c5a67984029' || $data->secret =='b7958f3be4ec7e6ce15f8b921e2fc53f00247f61576266') {
//if($_GET['id']){
    $vk_user_id=71357988;
    $vk_firstname='Виктория';
    $vk_lastname='Марченко';
    /*$vk_user_id=$data->object->vk_user_id;
    $vk_firstname=$data->object->first_name;
    $vk_lastname=$data->object->last_name;
    $vk_group_id=$data->object->vk_group_id;*/
    //$vk_group_id='';
    //$file='[doc id=484068682 owner_id=317258144 url=https:\/\/vk.com\/doc317258144_484068682?hash=f469be53473ce77862&dl=GMYTOMRVHAYTINA:1593455445:15b166396c21f80c3d&api=1&no_preview=1]';
    /*if(isset($data->object->variables->file)){
       $file=$data->object->variables->file;
    //if(isset($file)){
       ////for($j=0; $j<count($file);$j++){
        //$mas=explode(']',$file[$j]);
        $mas=explode(']',$file);
       $str='Файлы: <br>';
     for($i=0; $i<count($mas)-1;$i++){
         $mas[$i]=substr($mas[$i],1);
        $mas[$i]=explode(' ',$mas[$i]);
        $mas[$i][3]=substr($mas[$i][3],4);
       $str.=($i+1).'. '.$mas[$i][3].'<br>';
     }
    } else {$str='Файл: Не требуется';}
    
    $area = $data->object->variables->area;
    $type = $data->object->variables->type;
    $discipline = $data->object->variables->discipline;
    $topic = $data->object->variables->topic;
    $ap = $data->object->variables->ap;
    $typeap = $data->object->variables->typeap;
    $comment = $data->object->variables->comment;
    $date = $data->object->variables->date;
    $thisidlead='';
    //$str='https://examen-na5.ru';
   /* $thisidlead='';
    $area = 'Гуманитарные предметы';
    $type = 'Задача';
    $discipline = 'Информатика';
    $topic = 'Базы данных';
    $ap = 70;
    $typeap = 'АП ВУЗ';
    $comment = 'Коммент';
    //$str='https://examen-na5.ru';
    $date = '20-07-2020';*/
    //function data($idlead){
    $data=array(array(
        //"name"=> 'Заказ №'.$thisidlead,
        "created_by"=> 0,
        "pipeline_id"=>2094802,
        "status_id"=>30161449,
        "custom_fields_values"=> array(
            array(
                "field_id"=> 460459,
                "values"=> array(
                    array(
                        "value"=> strtotime($date)
                    )
                )
            ),
             array(
                "field_id"=> 454331,
                "values"=> array(
                    array(
                        "value"=> $area
                    )
                )
            ),
             array(
                "field_id"=> 454333,
                "values"=> array(
                    array(
                        "value"=> $type
                    )
                )
            ),
            array(
                "field_id"=> 454335,
                "values"=> array(
                    array(
                        "value"=> $discipline
                    )
                )
            ),
             array(
                "field_id"=> 454337,
                "values"=> array(
                    array(
                        "value"=> $str
                    )
                )
            ),
             array(
                "field_id"=> 454339,
                "values"=> array(
                    array(
                        "value"=> $comment
                    )
                )
            ),
            array(
                "field_id"=> 454341,
                "values"=> array(
                    array(
                        "value"=> $topic
                    )
                )
            ),
             array(
                "field_id"=> 454343,
                "values"=> array(
                    array(
                        "value"=> $ap
                    )
                )
            ),
             array(
                "field_id"=> 454345,
                "values"=> array(
                    array(
                        "value"=> $typeap
                    )
                )
            ),
        )
        )
);
/*return $data;
}*/

$method='v4/contacts';
$arParams='limit=250&with=catalog_elements&page=';
$page=1;
$arParams.=$page;
$arResponse=request($arParams,$method);
$listcontact=[];
$listcontact=array_merge($listcontact,$arResponse['_embedded']['contacts']);
while ($arResponse !== null) {
if (count($arResponse['_embedded']['contacts']) >= 250) {
    sleep(1);
    $arParams='limit=250&with=catalog_elements&with=customers&page=';
     $page++;
    $arParams.=$page;
$arResponse=request($arParams,$method); 
$listcontact=array_merge($listcontact,$arResponse['_embedded']['contacts']);
} else 
$arResponse = null;
} 
//echo '<pre>';
//var_dump($listcontact);
//echo '<pre>';
for ($i=0; $i<count($listcontact); $i++){
$thiscontact=$listcontact[$i]["custom_fields_values"][0]["values"][0]["value"];
if ($thiscontact=='https://vk.com/id'.$vk_user_id){
    $idthiscontact=$listcontact[$i]['id'];
    break;
}
}
if (!$idthiscontact){
    $method='v4/leads/unsorted';
$arParams='limit=250';   
$primary =request($arParams,$method);
   for ($i=0; $i<count($primary['_embedded']['unsorted']); $i++){
if ($primary['_embedded']['unsorted'][$i]['metadata']['from']== $vk_firstname.' '.$vk_lastname && $primary['_embedded']['unsorted'][$i]['metadata']['to']==$vk_group_id){
        $thisidlead=$primary['_embedded']['unsorted'][$i]['_embedded']['leads'][0]['id'];
       $idthiscontact=$primary['_embedded']['unsorted'][$i]['_embedded']['contacts'][0]['id'];
       $uid=$primary['_embedded']['unsorted'][$i]['uid'];
    break;
}
}
if ($uid){
     $method="v4/leads/unsorted/$uid/accept";
$reques=create([],$method);
sleep(1);
}
}
if (!$idthiscontact){
    $idthiscontact_mas=[];
   for ($i=0; $i<count($listcontact); $i++){
if ($listcontact[$i]['first_name']== $vk_firstname && $listcontact[$i]['last_name']==$vk_lastname && $listcontact[$i]["custom_fields_values"][0]["values"][0]["value"]!=='https://vk.com/id'.$vk_user_id){
    $idthiscontact_mas[]=$listcontact[$i]['id'];
    break;
}
} 
if (count($idthiscontact_mas)==1){
    $idthiscontact=$idthiscontact_mas[0];
}
/*echo 'Массив с найденными контактами: <br>';
Var_dump($idthiscontact);*/
}
sleep(1);
if ($idthiscontact){
$method='v4/leads/unsorted';
$arParams='limit=250';   
$primary =request($arParams,$method);
echo 'Массив заявок в первоначальном контакте: <br>';
if ($idthiscontact[0]){
for ($j=0; $j<count($primary ['_embedded']['unsorted']);$j++){
/*echo '<pre>';
 var_dump($primary);
echo '<pre>';*/
/*for ($k=0; $k<count($idthiscontact);$k++){
    if ($idthiscontact[$k]==$primary['_embedded']['unsorted'][$j]['_embedded']['contacts'][0]['id']){
        $thisidlead=$primary['_embedded']['unsorted'][$j]['_embedded']['leads'][0]['id'];
       $idthiscontact=$idthiscontact[$k];
       $uid=$primary['_embedded']['unsorted'][$j]['uid'];
        break;
    }
}*/
/*}
if($idthiscontact[0]){
    $idthiscontact=$idthiscontact[0];
}
sleep(1);*/
$method='v4/contacts/'.$idthiscontact;
    $datacontacts=array(
        "custom_fields_values"=> array(array(
                "field_id"=> 59057,
                "values"=> array(
                    array(
                        "value"=> 'https://vk.com/id'.$vk_user_id
                    )
                )
            )
            )
        );
        $reques=edit($datacontacts,$method);
        sleep(1);
} else{
 for ($j=0; $j<count($primary ['_embedded']['leads']);$j++){
    if ($idthiscontact==$primary['_embedded']['unsorted'][$j]['_embedded']['contacts'][0]['id']){
        $thisidlead=$primary['_embedded']['unsorted'][$j]['_embedded']['leads'][0]['id'];
        $uid=$primary['_embedded']['unsorted'][$j]['uid'];
        break;
    }
}   
}*/

/*if ($thisidlead){
     /*$method="v4/leads/unsorted/$uid/accept";
$reques=create([],$method);
sleep(1);*/
/* $method='v4/leads/'.$thisidlead;
 //$data=data($thisidlead);
/*$reques=edit($data[0],$method);
} else {
  $method='v4/leads';
  echo 'Создание сделки с найденным контактом: <br>';
$reques=create($data,$method);
$thisidlead=$reques[ "_embedded"]['leads'][0]['id'];
sleep(1);
$method='v4/leads/'.$thisidlead.'/link';
$datacontacts=array(array(
        "to_entity_id"=> $idthiscontact,
        "to_entity_type"=>'contacts',
        "metadata"=>array(
        "is_main"=>true
        )
        ));
/*echo 'Привязка контакта: <br>';
echo '<pre>';*/
/*Var_dump(*//*$reques=create($datacontacts,$method)*//*)*/;
//echo '</pre>';
/*}
}
else{
    sleep(1);
    $method='v4/contacts';
    $datacontacts=array(array(
        "name"=> $vk_firstname.' '.$vk_lastname,
        "first_name"=>$vk_firstname,
        "last_name"=>$vk_lastname,
        "custom_fields_values"=> array(
            array(
                "field_id"=> 59057,
                "values"=> array(
                    array(
                        "value"=> 'https://vk.com/id'.$vk_user_id
                    )
                )
            )
        )
        )
        );
/*echo 'Создание контакта: <br>';
echo '<pre>';*/
/*var_dump(*//*$reques=create($datacontacts,$method)*//*)*/;
/*echo '</pre>';*/
/*$idthiscontact=$reques[ "_embedded"]['contacts'][0]['id'];
sleep(1);
$method='v4/leads';
/*echo 'Создание сделки: <br>';*/
/*$reques=create($data,$method);
$thisidlead=$reques[ "_embedded"]['leads'][0]['id'];
sleep(1);
$method='v4/leads/'.$thisidlead.'/link';
/*echo 'Привязка контакта с созданной сделки: <br>';*/
/*$datacontacts=array(array(
        "to_entity_id"=> $idthiscontact,
        "to_entity_type"=>'contacts',
        "metadata"=>array(
        "is_main"=>true
        )
        ));
/*echo '<pre>';
var_dump(*//*$reques=create($datacontacts,$method)/*)*/;
/*echo '</pre>';*/
/*}
sleep(1);
$data=array(
        "name"=> 'Заказ №'.$thisidlead,
        );
 $method='v4/leads/'.$thisidlead;
//  $data=data($thisidlead);
$reques=edit($data,$method);
sleep(1);
$note="Заказ №'$thisidlead
Область: $area
Тип работы: $type
Дисциплина:$discipline
Тема работы: $topic
Процент уникальности: $ap
Тип антиплагиата: $typeap
Комментарий: $comment
Сроки: $date
$str
Группа ВК: $vk_group_id";
 $method='v4/leads/notes';
$datanotes=array(array(
        "entity_id"=> $thisidlead,
        "note_type"=>'common',
        "params"=>array(
        "text"=> $note
        )
        ));
$reques=create($datanotes,$method);
if($area=='Гуманитарные предметы'){
	  	$peer_id=2000000002;  
	} else if($area=='Информатика, программирование'){
	    $peer_id=2000000001;  
	}else if($area=='Экономика, финансы'){
	    $peer_id=2000000008;  
	}else if($area=='Технические предметы'){
	    $peer_id=2000000009;  
	} else{
	    $peer_id=71357988;
	}
	$message='Заказ №'.$thisidlead.
'<br>Область: '. $area.
'<br> Тип работы: '.$type.
'<br>Дисциплина: '.$discipline.
'<br> Тема работы: '.$topic.
'<br> Процент уникальности: '.$ap.
'<br> Тип антиплагиата: '.$typeap.
'<br> Комментарий: '.$comment.
'<br> Сроки: '.$date.'<br>'.$str;
$request_params = array(
            'message' => $message ,
            'peer_id' =>  $peer_id,
            'access_token' => $token,
            'random_id'=>0,
            'v' => '5.103'
        );
         $get_params = http_build_query($request_params);

     echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
     echo('ok');
 /*$message='Ваш заказ №'.$thisidlead.'<br>Область: '. $area.'<br> Тип работы: '.$type.'<br>Дисциплина: '.$discipline.'<br> Тема работы: '.$topic.'<br> Процент уникальности: '.$ap.'<br> Тип антиплагиата: '.$typeap.'<br> Комментарий: '.$comment.'<br> Сроки: '.$date.'<br>'.$str;
$request_params = array(
            'message' => $message ,
            'peer_id' =>  $vk_user_id,
            'access_token' => $token,
            'random_id'=>0,
            'v' => '5.103'
        );
         $get_params = http_build_query($request_params);

     echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
     echo('ok');*/

     }
  
        
//}
?>