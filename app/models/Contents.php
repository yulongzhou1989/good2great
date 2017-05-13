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

    /**
     * This model is mapped to the table sample_cars
     */
    public function getSource()
    {
        return "contents";
    }

}
