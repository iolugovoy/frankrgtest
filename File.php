<?php

require_once("FileManager.php");

class File
{


    public function getFolderContent()
    {
        $currentDir = $_POST['current'];
        $targetPath = $_SERVER["DOCUMENT_ROOT"] . '/files/' .  $currentDir ;

        if (scandir($targetPath)){
            $rawContents = scandir($targetPath);
            $contents = array_diff($rawContents, array('..', '.'));
            foreach ($contents as $index => $value) {
                $contents[$index] = $currentDir . '/' . $value;
            }
            return $contents;

        } else {
            $error = error_get_last();
            return $error['message'];
        }

    }

    public function uploadFile( string $fileName): string {
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $fileName)) {
            $error = error_get_last();
            return $error['message'];
        } else {
            return "success";
        }
    }

    public function rename(string $oldName, string $newName): string {
        if (!rename($oldName, $newName)) {
            $error = error_get_last();
            return $error['message'];
        } else {
            return 'success';
        }
    }

    public function deleteRecursive(string $path): string {
        if ( is_dir($path) ) {
            if (substr($path, strlen($path) - 1, 1) != '/') {
                $path .= '/';
            }
            $files = glob($path . '*');

            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteRecursive($file);
                } else {
                    unlink($file);
                }
            }

            if(!rmdir($path)){
                $error = error_get_last();
                return $error['message'];
            } else {
                return 'success';
            }
        } else {
            if(!unlink($path)){
                $error = error_get_last();
                return $error['message'];
            } else {
                return 'success';
            }

        }
    }

    public function createFolder( string $path): string {
        if (!mkdir($path)) {
            $error = error_get_last();
            return $error['message'];
        } else {
            return "success";
        }
    }


}