<?
header("Content-Type: text/html; charset=utf-8"); 
function auth(){
    $user = array(
        'USER_LOGIN' => 'm.n.i.mo@mail.ru',
        'USER_HASH' => '64ef8ae45cadb59fe2a8d3b276ece3aced61a95e',
    );
    $subdomain = 'mnimo'; 
    $link = 'https://' . $subdomain . '.amocrm.ru/private/api/auth.php?type=json';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname
        (__FILE__) . '/cookie.txt'); 
    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname
        (__FILE__) . '/cookie.txt');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl); 
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    curl_close($curl); 
    $code = (int) $code;
    $errors = array(
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    );
    try
    {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        if ($code != 200 && $code != 204) {
            throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        }

    } catch (Exception $E) {
        die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
    }
    $Response = json_decode($out, true);
    $Response = $Response['response'];
    if (isset($Response['auth'])) #Флаг авторизации доступен в свойстве "auth"
    {
        return 'Авторизация прошла успешно';
    } else {
        return 'Авторизация не удалась';
    }
}
?>