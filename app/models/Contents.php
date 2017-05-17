<?php

use Phalcon\Mvc\Model;

class Contents extends Model
{
    public $id;

    public $userid;

    public $title;

    public $content;

    public $date;

    public $updateDate;

    public $top;

    public $category;

    public $catHtml;

    public function setCatHtml($catHtml){
        $this->catHtml = $catHtml;
    }

    /**
     * This model is mapped to the table sample_cars
     */
    public function getSource()
    {
        return "contents";
    }
}
