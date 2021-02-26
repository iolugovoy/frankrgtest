<?php
error_reporting(0);
require_once("FileManager.php");
require_once("File.php");



$Manager = new FileManager();

$methods = [
    "upload" => "uploadFile",
    "get" => "getList",
    "create" => "createFolder",
    "delete" => "delete",
    "rename" => "rename",
    "load" => "loadFile"
];

//$Manager->getFolderContent();

//var_dump($_POST);

foreach ($methods as $actionName => $methodName) {

    if(isset($_POST['action']) && $_POST['action'] == $actionName){

        $Manager->$methodName();
    }

}

?>