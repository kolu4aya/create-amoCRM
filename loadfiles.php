<?
header('Content-Type: text/html; charset=utf-8');
$confirmationToken = '8a0a69d3';
$secretKey = 'aa1122qqzz';
$token = '750c3ab3b19c1a825031031fa6769f8d781fa4bcfbc5f9177ec77d49f98be594f5bbbdf39f00c5dc0ba77';
// if(strcmp($data->secret, $secretKey) !== 0 && strcmp($data->type, 'confirmation') !== 0)
//     return;

$data = json_decode(file_get_contents('php://input'));
if ($data->type=='confirmation') {
        echo $confirmationToken;
}		
$url = 'https://sun9-7.userapi.com/impg/DPAkqGDTkbJ1nScNCowmwxXxZW6ocf6hD1cxUw/tz64lHeX65A.jpg?size=313x49&quality=96&proxy=1&sign=20c05307f3044bf13ae880a868b006bb&c_uniq_tag=FXg5Rz8GiGbJlns4Fn5csrK1riarI8vQ4giU-w2p0hI&type=album';
if(!is_dir($dir)) {
mkdir('files');
}
$file_name=basename(substr($url, 0, strpos($url, '?')));
$file_puth = 'files/'.basename(substr($url, 0, strpos($url, '?')));   
if (copy($url,$file_puth)){
    echo "File downloaded successfully";
}
else {
    echo "File downloading failed.";
}
$request_params = array(
            
            'access_token' => $token,
            'v' => '5.103'
        );
         $get_params = http_build_query($request_params);
// echo "<pre>";
$upload_url=json_decode(file_get_contents('https://api.vk.com/method/photos.getMessagesUploadServer?' . $get_params))->response->upload_url;
// echo "</pre>";
// copy($file,'./tempimg.jpg');
// $lala = "./tempimg.jpg";
$cfile = curl_file_create($file_puth,'image/jpeg',$file_name);
$postparam = array("file1"=>$cfile);

$ch = curl_init($upload_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postparam);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=UTF-8'));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$json = json_decode(curl_exec($ch), true);
curl_close($ch);
$request_params = array(
             'server' => $json['server'],
                'photo' => $json['photo'],
                'hash' => $json['hash'],
            'access_token' => $token,
            'v' => '5.126'
        );
         $get_params = http_build_query($request_params);
         echo '<pre>';
var_dump($photo=json_decode(file_get_contents('https://api.vk.com/method/photos.saveMessagesPhoto?' . $get_params)));
echo '</pre>';
$massage="Тут текст";
$owner_id=$photo->response[0]->owner_id;
$id=$photo->response[0]->id;
$access_key=$photo->response[0]->access_key;
$request_params = array(
             'message' => $massage,
                'user_id' => '71357988',
                'random_id' => 123,
                'attachment' => 'photo'.$owner_id.'_'.$id.'_'.$access_key,
            'access_token' => $token,
            'v' => '5.103'
        );
         $get_params = http_build_query($request_params);
var_dump(file_get_contents('https://api.vk.com/method/messages.send?' . $get_params));
echo 'ok';
?>