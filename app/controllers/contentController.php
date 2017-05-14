<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class ContentController extends Controller
{
  public function indexAction()
  {
      $request = new Request();
      $contentID = $request->get("id");

      if($contentID){
        // $query = $this->modelsManager->createQuery(
        //   "SELECT c.id, u.username, c.title, c.content, c.date, c.updateDate" .
        //   " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE c.id = :id:");
        // $row = $query->execute(
        //   [
        //       "id" => $contentID,
        //   ]
        // );
        $content = $this->modelsManager->executeQuery(
          "SELECT c.id, u.username, c.title, c.content, c.date, c.updateDate" .
          " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE c.id = :id:",
          [
              "id" => $contentID,
          ]
        );
        echo "I am here";
      } else{
        $this->response->redirect('/category');
        $this->view->disable();
      }
      //print_r($content->getFirst());
      //print_r($this->modelsManager);
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
