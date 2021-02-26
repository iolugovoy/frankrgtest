<?php

require_once("File.php");

class FileManager
{

    function __construct() {
        $this->file = new File();
        $this->root = "/files/";
    }

    private function getFolderPath($folderName) {
        return $_SERVER["DOCUMENT_ROOT"] . $this->root  . $folderName;
    }
    public function getList() {
        $contents = $this->file->getFolderContent();
        $isSuccess = !is_string($contents);
        $this->response(["isSuccess" => $isSuccess , "data" => $contents ]);
    }



    public function response($response)
    {
        echo json_encode($response);
    }

    public function rename()
    {
        $oldName = $this->getFolderPath($_POST['oldname']);
        $newName = $this->getFolderPath($_POST['newname']);
        $result = $this->file->rename($oldName, $newName);
        $contents = $this->file->getFolderContent();
        $isSuccess = $result === 'success';
        $this->response(["isSuccess" => $isSuccess , "data" => $isSuccess ? $contents : $result]);
    }

    public function uploadFile(): void
    {
        $fileName = $this->getFolderPath($_POST['current']);
        $result = $this->file->uploadFile($fileName . '/' . $_FILES['file']['name']);
        $contents = $this->file->getFolderContent();
        $isSuccess = $result === 'success';
        $this->response(["isSuccess" => $isSuccess , "data" => $isSuccess ? $contents : $result]);

    }

    public function createFolder(): void
    {
        $newFolder = $this->getFolderPath($_POST['current'] .'/'. $_POST['foldername']);
        $result = $this->file->createFolder($newFolder);;
        $contents = $this->file->getFolderContent();
        $isSuccess = $result === 'success';
        $this->response(["isSuccess" => $isSuccess , "data" => $isSuccess ? $contents : $result]);
    }


    public function delete() {

        $name = $_POST['filename'];
        $path = $this->getFolderPath($name);
        $result = $this->file->deleteRecursive($path);
        $contents = $this->file->getFolderContent();
        $isSuccess = $result === 'success';
        $this->response(["isSuccess" => $isSuccess , "data" => $isSuccess ? $contents : $result]);

    }

}