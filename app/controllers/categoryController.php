<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Common\Helper as Helper;

class CategoryController extends Controller
{
    protected function _getCategoryHtml($category){
      $arr = explode(",", $category);
      $html = "";
      foreach($arr as $c){
        $html .=  "<strong><a href='categroy/search?cat=". $c ."'>" . $c . "</a></strong>,";
      }
      return substr($html, 0, -1);
    }

    public function indexAction()
    {
        $request = new Request();
        $categoryID = $request->get("catID");
        $numberPage = $request->get("pageNum");
        if(!$numberPage){
          $numberPage = 1;
        }

        $limit = $this->config->pagination->limit;
        $offset = ($numberPage-1)*$limit;
        $contentList;
        if($categoryID){
          $contentList = $this->modelsManager->executeQuery(
            " SELECT c.id, u.username, c.date, c.title, " .
            " GROUP_CONCAT(cc.categoryID) AS categoryIDs, GROUP_CONCAT(cc.categoryName) AS categoryNames".
            " FROM contents c LEFT JOIN content_cat cc ON cc.contentID = c.id " .
            " LEFT JOIN users u ON c.userid = u.id  WHERE c.category like :id: ".
            " GROUP BY c.id, c.date, c.title, u.username".
            " LIMIT :limit: OFFSET :offset:",
            [
                "id" => "%,".$categoryID.",%",
                "limit"=> $limit,
                "offset"=> $offset,
            ]
          );
        } else{
          $contentList = $this->modelsManager->executeQuery(
            " SELECT c.id, u.username, c.date, c.title," .
            " GROUP_CONCAT(cc.categoryID) AS categoryIDs, GROUP_CONCAT(cc.categoryName) AS categoryNames".
            " FROM contents c LEFT JOIN content_cat cc ON cc.contentID = c.id " .
            " LEFT JOIN users u ON c.userid = u.id GROUP BY c.id, c.date, c.title, u.username"
          );
        }

        //get category list
        $catList = $this->modelsManager->executeQuery(
          " SELECT c.categoryName, c.categoryID, count(c.contentID) as num ".
          " FROM content_cat c GROUP BY c.categoryID, c.categoryName"
        );

        //get category tags html
        $viewList = $contentList->toArray();
        for ($x = 0; $x <count($viewList); $x++){
          $cat =$viewList[$x]["categoryNames"];
          $viewList[$x]["catHtml"] = $this->_getCategoryHtml($cat);
        }

        //render
        $paginator = new Paginator(array(
            "data"  => $contentList,
            "limit" => $limit,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->contentList = $viewList;
        $this->view->config = $this->config;
        $this->view->catList = $catList;
    }
}
