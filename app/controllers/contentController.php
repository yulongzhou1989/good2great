<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Manager as ModelsManager;

class ContentController extends Controller
{
  public function indexAction()
  {
      $request = new Request();
      $contentID = $request->get("id");

      if($contentID){
        $content = $this->modelsManager->executeQuery(
          "SELECT  c.id, u.username, c.title, c.content, c.date, c.updateDate" .
          " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE c.id = :id:",
          [
              "id" => $contentID,
          ]
        );
      } else{
        $this->response->redirect('/category');
        $this->view->disable();
      }

      //render
      $this->view->content = $content;
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
