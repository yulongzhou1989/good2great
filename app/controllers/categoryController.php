<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Paginator\Pager;

class CategoryController extends Controller
{
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

        if($categoryID){
          $contentList = $this->modelsManager->executeQuery(
            " SELECT c.id, u.username, c.date, c.title ".
            " FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE id = :id: ".
            " LIMIT :limit: OFFSET :offset:",
            [
                "id" => $categoryID,
                "limit"=> $limit,
                "offset"=> $offset
            ]
          );
        } else{
          $contentList = $this->modelsManager->executeQuery(
            'SELECT c.id, u.username, c.date, c.title FROM contents c LEFT JOIN users u ON c.userid = u.id'
          );
        }

        //render
        $paginator = new Paginator(array(
            "data"  => $contentList,
            "limit" => $limit,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->contentList = $contentList;
        $this->view->config = $this->config;
    }
}
