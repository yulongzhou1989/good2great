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
        $contentID = $request->get("id");
        //get data from db
        $content = Contents::findFirstById();
        //render
        $this->view->content = $content;
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
        if (!$this->request->isPost()) {
            $id = $this->request->getPost("id", "int");
            $content = Contents::findFirstById($id);

            if (!$content) {
                  $this->flash->error(
                  "Content was not found"
            );

            return $this->dispatcher->forward(
                  [
                    "controller" => "content",
                    "action"     => "index",
                  ]
                );
            }

            $this->view->content = $content;
        }
    }

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {
        // ...
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "content",
                    "action"     => "index",
                ]
            );
        }

        $id = $this->request->getPost("id", "int");

        $content = Contents::findFirstById($id);

        if (!$product) {
            $this->flash->error(
                "Content does not exist"
            );

            return $this->dispatcher->forward(
                [
                    "controller" => "content",
                    "action"     => "index",
                ]
            );
        }

        $data = $this->request->getPost();

        if ($content->save() === false) {
            $messages = $content->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "content",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success(
            "Product was updated successfully"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "content",
                "action"     => "index",
            ]
        );
    }

    /**
     * Deletes an existing product
     */
    public function deleteAction($id)
    {
        // ...
    }
}
