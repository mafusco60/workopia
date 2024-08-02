<?php

namespace App\Controllers;

use Framework\Database;

class FileController {
  
  protected $db;

  public function __construct(){
    $config = require basepath('config/db.php');
    $this->db = new Database($config);
  }

  public function upload (){
    $file = $_FILES['image'];

  if ($file['error'] === UPLOAD_ERR_OK) {
    // Specify where to upload
    $uploadDir = '/images/';

    // Check and create dir
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Create file name
    $filename = $file['name'];

    // Check file type
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Make sure extension is in array
    if (in_array($fileExtension, $allowedExtensions)) {
      // Upload file
      if (move_uploaded_file($file['tmp_name'], $uploadDir .  $filename)) { 
        $messages[]= ['text'=>'File Uploaded!', 'color'=> 'text-green-500'];
        $submitted= true;
      } else {
        $messages[]= ['text'=>'File Upload Error', 'color'=>'text-rose-600'];
        $submitted = false;
      }
    } else {
      $messages[] = ['text'=>'Invalid File Type', 'color'=>'text-rose-600'];
      $submitted = false;
    }
  }

}
  }

