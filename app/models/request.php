<?php
use Phalcon\Mvc\Model;

class request extends Model{

  public $request_id;
  public $Request_date;
  public $Student_id;

  public function inintialize()
  {

}

public function getId()
{
    return $this->request_id;
}

  
}