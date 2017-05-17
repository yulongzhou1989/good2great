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
        $categoryID = $request->get("id");
        $numberPage = $request->get("pageNum");
        if(!$numberPage){
          $numberPage = 1;
        }

        $limit = $this->config->pagination->limit;
        $offset = ($numberPage-1)*$limit;
        $contentList;
        if($categoryID){
          $contentList = $this->modelsManager->executeQuery(
            " SELECT c.id, u.username, c.date, c.title, c.category ".
            " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE id like :id: ".
            " LIMIT :limit: OFFSET :offset:",
            [
                "id" => "%,".$categoryID.",%",
                "limit"=> $limit,
                "offset"=> $offset,
            ]
          );
        } else{
          $contentList = $this->modelsManager->executeQuery(
            'SELECT c.id, u.username, c.date, c.title, c.category FROM contents c LEFT JOIN users u ON c.userid = u.id'
          );
        }

        //render
        $paginator = new Paginator(array(
            "data"  => $contentList,
            "limit" => $limit,
            "page"  => $numberPage
        ));

        $viewList = $contentList->toArray();
        for ($x = 0; $x <count($viewList); $x++){
          $cat =$viewList[$x]["category"];
          $viewList[$x]["catHtml"] = $this->_getCategoryHtml($cat);
        }

        $this->view->page = $paginator->getPaginate();
        $this->view->contentList = $viewList;
        $this->view->config = $this->config;
    }

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

    }
}
