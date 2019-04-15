<?php
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;

class students extends Model{

  public $Student_id;
  public $Student_Name;
  public $client_id;


  public function validation()
  {
    $validator = new Validation();
      $validator->add(
          'Student_id',
          new Uniqueness(
              [
                  'model'   => $this,
                  'message' => 'Another user with same Student ID already exists',
                  'cancelOnFail' => true,
              ]
          )
      );
      return $this->validate($validator);
  }


  public function inintialize()
  {

}

  
}