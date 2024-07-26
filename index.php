<?
// $confirmationToken = '521538fd';
// $secretKey = 'aa1122qqzz';
// $token = '750c3ab3b19c1a825031031fa6769f8d781fa4bcfbc5f9177ec77d49f98be594f5bbbdf39f00c5dc0ba77';
$confirmationToken = '0a3dfc20';
$secretKey = 'aa1122qqzz';
$token = '72df94cc1ed2428185fd518fd8b250a1c9d6770d36344c04d770d2837e7806dbd3d1d8cff703219280e00';

if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;

$data = json_decode(file_get_contents('php://input'));
$message=json_encode($data);
$request_params = array(
    'message' => $message ,
    'peer_id' =>  71357988,
    'access_token' => $token,
    'random_id'=>685,
    'v' => '5.103'
);
$get_params = http_build_query($request_params);

echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
echo('ok');
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
if ($data->secret =='e5e360ffc5f28b286183ea32aa46bc9683a0bd30935207' || 
    $data->secret =='4d6f5b2cf0ada0036f079a04b59acc605eb21e89513784'  || 
    $data->secret =='2b2d693bc7c262d47ae5b0343e10f47f7617ec9c'  || 
    $data->secret =='ffc54fe08eca14f27b3c07db01679ccd0859d045907196' || 
    $data->secret =='81f3572099a5110f3858cd183de75047c36c5a67984029' || 
    $data->secret =='b7958f3be4ec7e6ce15f8b921e2fc53f00247f61576266') {

    $vk_user_id=$data->object->vk_user_id;
    $vk_firstname=$data->object->first_name;
    $vk_lastname=$data->object->last_name;
    $vk_group_id=$data->object->vk_group_id;
    if(isset($data->object->variables->file)){
       $file=$data->object->variables->file;

        if(isset($file)){
            $re = '/https:\/\/[^\s\]]*/';

            preg_match_all($re, $file, $matches, PREG_SET_ORDER, 0);
            $str='Файлы: <br>';
            for($i=0; $i<count($matches);$i++){
                $str.=($i+1).'. '.$matches[$i][0].'<br>';
            }
            $re = '/^[^\[]*/';
            preg_match_all($re, $file, $matches, PREG_SET_ORDER, 0);  
            $strcomm=  $matches[0][0];
        }
    } else {$str='Файл: Нет';}
    
    $area = $data->object->variables->area;
    $type = $data->object->variables->type;
    $discipline = $data->object->variables->discipline;
    $topic = $data->object->variables->topic;
    $ap = $data->object->variables->ap;
    $typeap = $data->object->variables->typeap;
    $comment = $data->object->variables->comment. '<br>'. $strcomm;
    $date = $data->object->variables->date;
    $thisidlead='';

    $data=array(array(
        "name"=> 'Заказ №'.$thisidlead,
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
            )
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
            if ($primary['_embedded']['unsorted'][$i]['metadata']['from']== $vk_firstname.' '.$vk_lastname && 
                $primary['_embedded']['unsorted'][$i]['metadata']['to']==$vk_group_id){

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
            if ($listcontact[$i]['first_name']== $vk_firstname && 
                $listcontact[$i]['last_name']==$vk_lastname && 
                $listcontact[$i]["custom_fields_values"][0]["values"][0]["value"]!=='https://vk.com/id'.$vk_user_id){
                $idthiscontact_mas[]=$listcontact[$i]['id'];
                break;
            }
        } 
        if (count($idthiscontact_mas)==1){
            $idthiscontact=$idthiscontact_mas[0];
        }
    }
    sleep(1);   
    if ($idthiscontact){
        sleep(1);
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
        if ($thisidlead){
            sleep(1);
            $method='v4/leads/'.$thisidlead;
            $reques=edit($data[0],$method);
        } else {
            $method='v4/leads';
            $reques=create($data,$method);
            $thisidlead=$reques[ "_embedded"]['leads'][0]['id'];
            sleep(1);
            $method='v4/leads/'.$thisidlead.'/link';
            $datacontacts=array(
                array(
                    "to_entity_id"=> $idthiscontact,
                    "to_entity_type"=>'contacts',
                    "metadata"=>array(
                        "is_main"=>true
                        )
                    )
                );

            $reques=create($datacontacts,$method);

        }
    }
    else{
        sleep(1);
        $method='v4/contacts';
        $datacontacts=array(
            array(
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
        /*echo 'Создание контакта: <br>';*/
        $reques=create($datacontacts,$method);

        $idthiscontact=$reques[ "_embedded"]['contacts'][0]['id'];
        sleep(1);
        $method='v4/leads';
        /*echo 'Создание сделки: <br>';*/
        $reques=create($data,$method);
        $thisidlead=$reques[ "_embedded"]['leads'][0]['id'];
        sleep(1);
        $method='v4/leads/'.$thisidlead.'/link';
        /*echo 'Привязка контакта с созданной сделки: <br>';*/
        $datacontacts=array(
            array(
            "to_entity_id"=> $idthiscontact,
            "to_entity_type"=>'contacts',
            "metadata"=>array(
                "is_main"=>true
                )
            )
        );

        $reques=create($datacontacts,$method);

        }
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
        Дисциплина:$discipline
        Комментарий: $comment
        Сроки: $date
        $str
        Группа ВК: $vk_group_id";
        $method='v4/leads/notes';
        $datanotes=array(
            array(
                "entity_id"=> $thisidlead,
                "note_type"=>'common',
                "params"=>array(
                    "text"=> $note
                    )
                )
            );
        $reques=create($datanotes,$method);
        if($area=='Гуманитарные предметы'){
            $peer_id=2000000002;  
        } else if($area=='Информатика, программирование'){
            $peer_id=2000000001;  
        }else if($area=='Экономика, финансы'){
            $peer_id=2000000008;  
        }else if($area=='Технические предметы'){
            $peer_id=2000000009;  
        } 
        $message='Заказ №'.$thisidlead.
        '<br>Область: '. $area.
        '<br>Дисциплина: '.$discipline.
        '<br> Комментарий: '.$comment.
        '<br> Сроки: '.$date.'<br>'.$str.
        '<br> Примечание: Пожалуйста, если Вы можете выполнить работу, но позднее указанного срока или можете выполнить только часть, то всё-равно пишите.';
        if (isset($peer_id)){
        $request_params = array(
                'message' => $message ,
                'peer_id' =>  $peer_id,
                'access_token' => $token,
                'random_id'=>0,
                'v' => '5.103'
            );
        } else {
        $request_params = array(
                'message' => $message ,
                'user_id' =>  71357988,
                'access_token' => $token,
                'random_id'=>0,
                'v' => '5.103'
            ); 
        }
        $get_params = http_build_query($request_params);

        echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
        $message='Ваш заказ №'.$thisidlead.'<br>Область: '. $area.'<br> Тип работы: '.$type.'<br>Дисциплина: '.$discipline.'<br> Тема работы: '.$topic.'<br> Процент уникальности: '.$ap.'<br> Тип антиплагиата: '.$typeap.'<br> Комментарий: '.$comment.'<br> Сроки: '.$date.'<br>'.$str;
        $request_params = array(
                    'message' => $message ,
                    'peer_id' =>  $vk_user_id,
                    'access_token' => $token,
                    'random_id'=>0,
                    'v' => '5.103'
                );
        $get_params = http_build_query($request_params);

        echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');

     } else if ($data->type=="message_new") {
         $message=$data->object->message->text;
         $pos=strpos($message, PHP_EOL);
         $area = substr($message, 0, $pos+1);
         $message=substr($message, $pos+1);
         $pos=strpos($area, ":");
         $area = substr($area, $pos+1);
         $re1 = '/.*номика/i';
         $re2 = '/.*уманитар.*/i';
         $re3 = '/.*ехническ.*/i';
         $re4 = '/.*нформатик.*/i';

         if(preg_match_all($re2, $area, $matches, PREG_SET_ORDER, 0)){
	  	    $peer_id=2000000002;  
        } else if(preg_match_all($re4, $area, $matches, PREG_SET_ORDER, 0)){
            $peer_id=2000000001;  
        }else if(preg_match_all($re1, $area, $matches, PREG_SET_ORDER, 0)){
            $peer_id=2000000008;  
        }else if(preg_match_all($re3, $area, $matches, PREG_SET_ORDER, 0)){
            $peer_id=2000000009;  
        } else {
            $peer_id=71357988;
        }
         $request_params = array(
            'message' => $message,
            'peer_id' =>  $peer_id,
            'access_token' => $token,
            'random_id'=>100,
            'v' => '5.103'
        );
         $get_params = http_build_query($request_params);

        echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
            
    }     
}
?>