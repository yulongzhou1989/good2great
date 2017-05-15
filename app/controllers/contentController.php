<?php
use Phalcon\Mvc\Controller;

class ContentController extends Controller
{
  public function indexAction()
  {
      $contentID = $this->request->get("id");
      if($contentID){
        $content = $this->modelsManager->executeQuery(
          "SELECT c.id, u.username, c.title, c.content, c.date, c.updateDate" .
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
       // ...
   }

   /**
    * Creates a product based on the data entered in the "new" action
    */
   public function createAction()
   {
       // ...
   }

   /**
    * Updates a product based on the data entered in the "edit" action
    */
   public function saveAction()
   {
       // ...
   }

   /**
    * Deletes an existing product
    */
   public function deleteAction()
   {
       // ...
   }
}
