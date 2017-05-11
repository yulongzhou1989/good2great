<?php

use Phalcon\Paginator\Adapter\Model as Paginator;

class CategoryController extends ControllerBase
{
    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        // ...
        $categoryID = $request->get("id");
        //get data from db
        $query = "SELECT * FROM contents";
        $contentsList = $this->modelsManager->executeQuery(
            "SELECT * FROM contents WHERE id = :id:",
            [
                "id" => $categoryID,
            ]
        );
        //render
        $paginator = new Paginator(array(
            "data"  => $contentList,
            "limit" => 10,
            "page"  => $numberPage
        ));
        $this->view->contentList = $contentList;
        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {
        // ...
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
    public function deleteAction($id)
    {
        // ...
    }
}
