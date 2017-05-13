<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Model\Manager as ModelsManager;

class CategoryController extends Controller
{

    public function indexAction()
    {
        $request = new Request();
        $categoryID = $request->get("id");
        $query = $categoryID?"SELECT * FROM contents WHERE id = :id:":"SELECT * FROM contents";
        //get data from db
        $contentsList = $this->modelsManager->executeQuery(
            $query,
            [
                "id" => $categoryID,
            ]
        );
        // $contentList = array(
        //   "1"=>array("id"=>"1","title"=>"babababawbabababababababababababaab","date"=>"2016-01-01"),
        //   "2"=>array("id"=>"1","title"=>"babababawbabababababababababababaab","date"=>"2016-01-01"),
        //   "3"=>array("id"=>"1","title"=>"babababawbabababababababababababaab","date"=>"2016-01-01"),
        //   "4"=>array("id"=>"1","title"=>"babababawbabababababababababababaab","date"=>"2016-01-01")
        // );


        //render
        // $paginator = new Paginator(array(
        //     "data"  => $contentList,
        //     "limit" => 10,
        //     "page"  => $numberPage
        // ));
        $this->view->contentList = $contentList;
        // $this->view->page = $paginator->getPaginate();
    }


}
