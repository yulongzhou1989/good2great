<?php
use Phalcon\Mvc\Controller;

class ContentController extends Controller
{

  protected function checkSession(){

      if ($this->session->has("userid")) {
          // Retrieve its value
          return $userID = $this->session->get("userid");
      } else {
          //redirect to category
      }
  }

  public function indexAction()
  {
      //checkSession();
      $contentID = $this->request->get("id");
      if($contentID){
        $content = $this->modelsManager->executeQuery(
          "SELECT c.id, u.username, c.title, c.content, c.date, c.updateDate, c.category" .
          " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE c.id = :id:",
          [
              "id" => $contentID,
          ]
        );
      } else{
        header("Location: category");
        exit();
      }
      //render
      $this->view->content = $content->getFirst();
  }

  /**
    * Shows the view to create a "new" product
    */
   public function newAction()
   {
       // ...
   }

   /**
    * Shows the view to "edit" an existing product
    */
   public function editAction()
   {
     //checkSession();
     $contentID = $this->request->get("id");
     if($contentID){
       $content = $this->modelsManager->executeQuery(
         "SELECT c.id, u.username, c.title, c.content, c.date, c.updateDate, c.category" .
         " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE c.id = :id:",
         [
             "id" => $contentID,
         ]
       );
     } else{
       header("Location: category");
       exit();
     }
     //render
     $this->view->content = $content->getFirst();
   }

   /**
    * Creates a product based on the data entered in the "new" action
    */
   public function createAction()
   {
       $userID = checkSession();
       $content = new Content();
       $content->userid = $userID ;
       $content->title = $this->request->getPost("title");
       $content->category = $this->request->getPost("category");
       $content->date = date("Y-m-d h:i:sa");
       $content->updateDate = date("Y-m-d h:i:sa");
       $content->content = $this->request->getPost("content");

       if ($content->create() === false) {
         echo "error";
       } else {
         echo "success";
       }
   }

   /**
    * Updates a product based on the data entered in the "edit" action
    */
   public function saveAction()
   {
       $userID = checkSession();
       $content = new Content();
       $content->id = $this->request->getPost("contentID");
       $content->userid = $userID;
       $content->title = $this->request->getPost("title");
       $content->category = $this->request->getPost("category");
       $content->date = date("Y-m-d h:i:sa");
       $content->updateDate = date("Y-m-d h:i:sa");
       $content->content = $this->request->getPost("content");

       if ($content->update() === false) {
         echo "error";
       } else {
         echo "success";
       }
   }

   /**
    * Deletes an existing product
    */
   public function deleteAction()
   {
       // ...
   }
}
