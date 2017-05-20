<?php
use Phalcon\Mvc\Model;

class Category extends Model
{
  public $id;

  public $categoryName;

  /**
   * This model is mapped to the table sample_cars
   */
  public function getSource()
  {
      return "category";
  }

}
