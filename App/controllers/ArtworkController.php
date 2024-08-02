<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;

class ArtworkController {
  
  protected $db;
/**
 * Undocumented function
 */
  public function __construct(){
    $config = require basepath('config/db.php');
    $this->db = new Database($config);
  }
  /**
   * Show all artworks
   *
   * @return void
   */
  public function index(){

    $artworks = $this->db->query('SELECT * FROM artworks ORDER BY created_at DESC')->fetchAll();

loadView('artworks/index', [
  'artworks' => $artworks
]);
  }
  /**
   * Show the Create artwork form
   *
   * @return void
   */
  public function create(){
    loadview('/artworks/create');
  }
  /**
   * Show a single artwork
   *
   * @param array $params
   * @return void
   */
  public function show($params){
    $id = $params['id'] ?? '';

    $params = [
    'id' => $id
];

  $artwork = $this->db->query ('SELECT * FROM artworks WHERE id = :id', $params)->fetch();

  // Check if artwork exists
  if(!$artwork){
    ErrorController::notFound('Artwork not found');
    return;
  }

  loadview('/artworks/show', ['artwork' => $artwork]);
  }


/**
 *  Store data in database
 * 
 * @return void
 */
  public function store (){
    
    $allowedFields = ['name','description', 'price', 'tags', 'original', 'substrate', 'featured', 'landscape', 'image', 'type', 'dimensions' ];

    $newArtworkData = array_intersect_key($_POST, array_flip($allowedFields));

    $newArtworkData = array_map('sanitize', $newArtworkData);

    // $newArtworkData['user_id'] = Session::get('user')['id'];
    
    $requiredFields = ['name','description', 'tags', 'original', 'type',  'image', 'landscape'  ];
    
    $errors = [];

    foreach($requiredFields as $field){
      if(empty($newArtworkData[$field]) || !Validation::string($newArtworkData[$field]))
      {
        $errors[$field] = ucfirst($field) . ' is required';
      }
    }

  if(!empty($errors)){
    // Reload view  with errors
    loadView('artworks/create', [
      'errors' => $errors,
      'artwork' => $newArtworkData
  ]);
} else {
  // Submit Data
  $fields = [];

  foreach($newArtworkData as $field => $value){
    $fields[] = $field;
  }

  $fields = implode(', ', $fields);

  $values = [];
  
  foreach($newArtworkData as $field => $value){
    // Convert empty strings to null
    if(trim($value) === '') {
     $newArtworkData[$field] = null;
    }
    $values[]= ':' . $field;
}
  $values = implode(', ', $values);

  $query = "INSERT INTO artworks ({$fields}) VALUES ({$values})";

  $this->db->query($query, $newArtworkData);

  Session::setFlashMessage('success_message', 'Artwork created successfully');
  return redirect('/artworks');

  redirect("/artworks");
}
}
/**
 * Delete an artwork
 *
 * @param
 * 
 * @return void
 */
public function destroy($params){

  $id = $params['id'];

  $params = [
    'id' => $id
  ];
$artwork = $this->db->query('SELECT * FROM artworks WHERE id = :id', $params)->fetch();

// Check if artwork exists
if (!$artwork) {
  ErrorController::notFound('Artwork not found');
  return;
}
// Authorization
/* if(!Authorization::isOwner($artwork->user_id)){

  Session::setFlashMessage('error_message', 'You are not authorized to delete this artwork');
  return redirect('/artworks/' . $artwork->id); */
//}

$this->db->query('DELETE FROM artworks WHERE id = :id', $params);

//Set flash message
Session::setFlashMessage('success_message', 'Artwork deleted successfully');
  return redirect('/artworks');
}
  /**
   * Show the artwork edit form
   *
   * @param array $params
   * @return void
   */
  public function edit($params){

    $id = $params['id'] ?? '';

    $params = [
    'id' => $id
];

  $artwork = $this->db->query ('SELECT * FROM artworks WHERE id = :id', $params)->fetch();

  // Check if artwork exists
  if(!$artwork){
    ErrorController::notFound('Artwork not found');
    return;
  }

   // Authorization
   /* if(!Authorization::isOwner($artwork->user_id)){
    Session::setFlashMessage('error_message', 'You are not authorized to update this artwork');
    return redirect('/artworks/' . $artwork->id);
} */

  loadview('/artworks/edit', ['artwork' => $artwork]);
  }
  /**
   * Update an artwork
   * 
   * @param array $params
   * @return void 
   */
  public function update($params) {
    $id = $params['id'] ?? '';

    $params = [
    'id' => $id
];

  $artwork = $this->db->query ('SELECT * FROM artworks WHERE id = :id', $params)->fetch();

  // Check if artwork exists
  if(!$artwork){
    ErrorController::notFound('Artwork not found');
    return;
  }
  // Authorization
  /* if(!Authorization::isOwner($artwork->user_id)){
    Session::setFlashMessage('error_message', 'You are not authorized to update this artwork');
    return redirect('/artworks/' . $artwork->id);
} */

$allowedFields = ['name','description', 'price', 'tags',       'original', 'substrate', 'featured', 'landscape', 'image', 'type', 'dimensions' ];

  

  $updateValues = [];
  $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

  $updateValues = array_map('sanitize', $updateValues);

  $requiredFields = ['name','description', 'tags', 'original', 'type',  'image', 'landscape'  ];

  $errors = [];

  foreach($requiredFields as $field){
    if(empty($updateValues[$field]) || !Validation::string($updateValues[$field])){
      $errors[$field] = ucfirst($field) . ' is required';

    }
  }
  if (!empty($errors)){
    loadView('/artworks/edit', [
      'artwork' => $artwork,
      'errors' => $errors
    ]);
    exit;
  } else {
    // Submit to database
    $updateFields = [];

    foreach(array_keys($updateValues) as $field){
      $updateFields[] = "{$field} = :$field";
    }
 
  $updateFields = implode(',', $updateFields);

  $updateQuery = "UPDATE artworks SET $updateFields WHERE id = :id";
    
  $updateValues['id']  = $id;

  $this->db->query($updateQuery, $updateValues);

  //Set flash message
Session::setFlashMessage('success_message', 'Artwork updated successfully');


  redirect('/artworks/' . $id);
      }
    }
    /**
     * Search artworks by keywords/location
     * 
     * @return void
     * 
     */
    public function search(){
      $keywords = isset($_GET['keywords']) ? trim ($_GET['keywords']) : '' ;
      // $location = isset($_GET['location']) ? trim ($_GET['location']) : '' ;

      $query = "SELECT * FROM artworks WHERE (name LIKE :keywords OR description LIKE :keywords OR tags LIKE :keywords OR type LIKE :keywords) ";

      $params = [
        'keywords' => "%{$keywords}%",
        // 'location' => "%{$location}%"
      ];

      $artworks = $this->db->query($query, $params)->fetchAll();
    loadView('/artworks/index',[
      'artworks' => $artworks,
      'keywords' => $keywords,      
      // 'location' => $location
    ]); 

 }
  }
