<?php

session_start();

if(!(array_key_exists('Logged', $_SESSION) and $_SESSION['Logged']==true)){
    echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
    exit();
}

$target_dir = "../PapaFilasRU/totem/Imagens/";
$target_filename = "anuncio";
$target_file_number = getFileNumber();
$target_file_extension = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
if ($target_file_extension!='jpg'){
     echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
    exit();
}
$target_filename = $target_filename.$target_file_number;
$target_file = $target_dir . $target_filename .'.jpg';
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
        exit();
    }
}

if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
     echo "<meta http-equiv=\"refresh\" content=\"0; url=upload_successful.php\" />";
    exit();
}
else{
     echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
    exit();
}


function getFileNumber(){
    $target_dir = "../PapaFilasRU/totem/Imagens/anuncio";
    for ($i=1; $i<11; $i++){
        $target_file = $target_dir.$i.'.jpg';
        if (!file_exists($target_file)){
        return $i;
        }
    }
    echo "<meta http-equiv=\"refresh\" content=\"0; url=erro.php\" />";
    exit();
}
?>
