<?php

session_start();

if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=login.php\" />";
    exit();
}

if(!empty($_POST['URL']) and !empty($_POST['DATA_INICIO']) and $_POST['DATA_FIM']){
        insertAdvertising($_POST['URL'], $_POST['DATA_INICIO'], $_POST['DATA_FIM']);
}
else{
    echo "<meta http-equiv=\"refresh\" content=\"0; url=upload_error.php\" />";
    exit();
}

function insertAdvertising($adress, $date_begin, $date_end){
    $advertisingParameters = array('URL' => $adress,
                                    'DATA_INICIO' => $date_begin,
                                    'DATA_FIM' => $date_end);
    $encodedAdvertisingParameters = json_encode($advertisingParameters);

    $requestAds =  stream_context_create(array(
            'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json; charset=utf-8 \r\n",
            'content' => $encodedAdvertisingParameters
        )
    ));

    $request = file_get_contents("http://35.199.101.182/api/propaganda", false, $requestAds);
    $response = json_decode($request, true);
    if ($response['MENSAGEM']!="Propaganda cadastrada com sucesso"){
        echo "<meta http-equiv=\"refresh\" content=\"0; url=upload_error.php\" />";
        exit();
    }
    else{
        echo "<meta http-equiv=\"refresh\" content=\"0; url=upload_successful.php\" />";
        exit();
    }

}
?>
