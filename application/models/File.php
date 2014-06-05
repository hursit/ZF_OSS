<?php

class Application_Model_File
{
    
    ///example createFolder('homeworks','homework_id');
    public function createFolder($folderName){
        umask("000");
        $path = APPLICATION_PATH."/../public/zip_files".$folderName;
        echo $path;
        if(!file_exists($path)){
            if (mkdir($path, 0777)){
                return true;
            }
            else{
                throw new Exception("Dosya izinlerinde sorun", 500, null);
            }
        }
        else{
            $this->folderDelete($path);
            if (mkdir($path, 0777)){
                return true;
            }
            else{
                throw new Exception("Dosya izinlerinde sorun", 500, null);
            }
        }
    }
    
    public function folderDelete($dir) { 
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
          (is_dir("$dir/$file")) ? $this->folderDelete("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    } 
    public function compressFolder($folderName){
       $path = APPLICATION_PATH."/../public/zip_files".$folderName;
       $zipPath = APPLICATION_PATH."/../public/zip_files/zipArchive.zip";
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
        $files = array();
        foreach (scandir($path) as $file) {
            if($file == "." || $file == ".."){
                continue;
            }
            array_push($files,$path."/".$file);
        }   
        return $files;
    }
}