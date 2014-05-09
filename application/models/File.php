<?php

class Application_Model_File
{
    
    ///example createFolder('homeworks','homework_id');
    public function createFolder($pathOnApplication,$folderName){
        umask("000");
        $path = APPLICATION_PATH."/../".$pathOnApplication."/".$folderName;
        if(!file_exists($path)){
            if (mkdir($path, 0777)){
                return true;
            }
            else{
                throw new Exception("Dosya izinlerinde sorun", 500, null);
            }
        }
        else{
            throw new Exception("Aynı dosya var", 500, null);
        }
    }
    public function compressFolder($pathOnApplication){
       $path = APPLICATION_PATH."/../".$pathOnApplication;
       $zipPath = APPLICATION_PATH."/../public/zipArchive.zip";
       if(file_exists($zipPath)){
           unlink($zipPath);
       }
       
       $zipName = "zipArchive.zip";
       $zip = new ZipArchive();
       $zip->open($zipName,  ZipArchive::CREATE);
       
       //Dosyaları tarayarak arşive atıyoruz.
       foreach (scandir($path) as $file) {
            if($file == "." || $file == ".."){
                continue;
            }
            
            //dosyayolu,zip'deki dosyaadi
           $zip->addFile($path."/".$file,$file);
       }  
       $zip->close();
    }
    public function folderFileList($pathOnApplication){
        foreach (scandir($path) as $file) {
            if($file == "." || $file == ".."){
                continue;
            }
            array_push($files,$path."/".$file);
        }   
        return $files;
    }
}