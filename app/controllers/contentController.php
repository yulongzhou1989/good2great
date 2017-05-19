<?php
use Phalcon\Mvc\Controller;


class ContentController extends Controller
{

  protected function _getCategoryHtml($category){
    $html = "";
    foreach($category as $c){
      $html .=  "<strong><a href='categroy/index?id=". $c["categoryId"] ."'>" . $c["categoryName"] . "</a></strong>,";
    }
    return substr($html, 0, -1);
  }

  protected function checkSession(){

      if ($this->session->has("userid")) {
          // Retrieve its value
          return $userID = $this->session->get("userid");
      } else {
          //redirect to category
          header("Location: category");
          exit();
      }
  }

  protected function getCatList(){
    $catList = $this->modelsManager->executeQuery(
      " SELECT c.categoryName, c.categoryID, count(c.contentID) as num ".
      " FROM content_cat c GROUP BY c.categoryName"
    );
    return $catList;
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

        $category = $this->modelsManager->executeQuery(
          "SELECT c.categoryID, c.categoryTitle, c.contentID" .
          " FROM content_cat c WHERE c.contentID = :id:",
          [
              "id" => $contentID,
          ]
        );

        $catList = $this->getCatList();
      } else{
        header("Location: category");
        exit();
      }

      $catList = $category->toArray();
      //render
      $this->view->content = $content->getFirst();
      $this->view->catHtml = $this->_getCategoryHtml($catList);
      $this->view->catList = $catList;
  }

  /**
    * Shows the view to create a "new" product
    */
   public function newAction()
   {
     $catDropdown =$this->_getCatDropdown();
     $catList = $this->getCatList();
     $this->view->catDropdown = $catDropdown;
     $this->view->catList = $catList;
   }

   protected function _getCatDropdown(){
       $cats = $this->modelsManager->executeQuery(
         "SELECT id, categoryName FROM category"
       ) ;
       return $cats;
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
       $catList = $this->getCatList();
     } else{
       header("Location: category");
       exit();
     }
     //render
     $this->view->catList = $catList;
     $this->view->content = $content->getFirst();
   }

   /**
    * Creates a product based on the data entered in the "new" action
    */
   public function createAction()
   {
       //$userID = $this->checkSession();
       $content = new Content();
      //  $catNames = $this->request->getPost("categoryNames");
      //  $catIDs = $this->request->getPost("categoryIDs");
       $content->userid = $userID ;
       $content->title = $this->request->getPost("title");
       $content->category = $catNames;
       $content->catIDs = $catIDs;
       $content->date = date("Y-m-d h:i:sa");
       $content->updateDate = date("Y-m-d h:i:sa");
       $content->content = $this->request->getPost("content");

       if ($content->save() === false) {
           echo "error";
           return ;
       } else {
          $this->_cont_catInsert($content->id, $catNames,$catIDs);
       }

       //redirect to new created page
   }

   protected function _cont_catInsert($contentID, $catNames, $catIDs){
         $insertCont_cat = "INSERT INTO content_cat (contentID, categoryID, categoryName) VALUES ";
         $catNameArr = explode("," , $catNames);
         $catIDArr = explode(",", $catIDs);
         $insertValues = array();
         for($x=0;$x<3*count($catIDArr);$x=$x+3){
           $insertCont_cat .= "(?" . $x . ",?" . $x+1 .",?" . $x+2 . " ),";
           array_push($insertValues, $contentID, $catIDArr[$x],$catNameArr[$x]);
         }

         $this->modelsManager->executeQuery(
            $insertCont_cat,
            $insertValues
         );
   }

   protected function _cont_catDeleteByContentID($contentID){
        $this->modelsManager->executeQuery(
            "DELETE FROM content_cat WHERE contentID = :contentID:",
            [
              "contentID" => $contentID
            ]
        );
   }

   /**
    * Updates a product based on the data entered in the "edit" action
    */
   public function saveAction()
   {
       $userID = checkSession();
       $content = new Content();
       $cats = $this->request->getPost("category");
       $content->id = $this->request->getPost("contentID");
       $content->userid = $userID;
       $content->title = $this->request->getPost("title");
       $content->category = $cats;
       $content->updateDate = date("Y-m-d h:i:sa");
       $content->content = $this->request->getPost("content");

       if ($content->update() === false) {
         echo "error";
       } else {
         $this->_cont_catDeleteByContentID($contentID);
         $this->_cont_catInsert($contentID, $cats);
       }

       //redirect to content
   }

   /**
    * Deletes an existing product
    */
   public function deleteAction()
   {
       // ...
   }
}
