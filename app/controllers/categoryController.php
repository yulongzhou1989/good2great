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
        $numberPage = 1;

        if($categoryID){
          $contentList = $this->modelsManager->executeQuery(
            ' SELECT c.id, u.username, c.date, c.title FROM contents c LEFT JOIN users u ON c.userid = u.id  WHERE id = :id:',
            [
                "id" => $categoryID,
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
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->contentList = $contentList;
    }
}
