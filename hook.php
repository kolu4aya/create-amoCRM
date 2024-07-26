<?
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
$confirmationToken = '1864716d';
$secretKey = 'aa1122qqzz';
$token = '750c3ab3b19c1a825031031fa6769f8d781fa4bcfbc5f9177ec77d49f98be594f5bbbdf39f00c5dc0ba77';
if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
    return;

$data = json_decode(file_get_contents('php://input'));
if ($data->type=='confirmation') {
    
        echo $confirmationToken;
}
if ($data->secret =='e5e360ffc5f28b286183ea32aa46bc9683a0bd30935207') {
    if($data->object->variables->file!=''){
        $mas=explode(']',$data->object->variables->file);
        $str='Файлы: <br>';
        for($i=0; $i<count($mas)-1;$i++){
            $mas[$i]=substr($mas[$i],1);
            $mas[$i]=explode(' ',$mas[$i]);
            $mas[$i][3]=explode('=',$mas[$i][3]);
            $str.=($i+1).'. '.$mas[$i][3][1].'<br>';
        }
    }
    $message=(string)$data->object->variables->order.'<br>'.$str;
    $request_params = array(
            'message' => $message,
            'peer_id' =>  71357988,
            'access_token' => $token,
            'random_id'=>0,
            'v' => '5.103'
    );
    $get_params = http_build_query($request_params);

    echo file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    echo('ok200');
}
$request_params = array(
    'access_token' => $token,
    'v' => '5.103'
);
$get_params = http_build_query($request_params);

$upload_url=json_decode(file_get_contents('https://api.vk.com/method/photos.getMessagesUploadServer?' . $get_params))->response->upload_url;

copy($file,'./tempimg.jpg');
$image = "./tempimg.jpg";
$cfile = curl_file_create($image,'image/jpeg','test_name.jpg');
$postparam = array("file1"=>$cfile);

$ch = curl_init($server);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postparam);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=UTF-8'));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$json = json_decode(curl_exec($ch));
curl_close($ch);
unlink('./tempimg.jpg');
    ?>