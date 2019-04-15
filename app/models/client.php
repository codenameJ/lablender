<?php
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;
// use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class client extends Model{

  public $ID;
  public $Name;
  public $Email;
  public $Password;
  public $Phone;

  public function validation()
    {
        $validator = new Validation();
        $validator->add(
            'Email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );
        $validator->add(
            'Email',
            new Uniqueness(
                [
                    'model'   => $this,
                    'message' => 'Another user with same email already exists',
                    'cancelOnFail' => true,
                ]
            )
        );
        return $this->validate($validator);
    }

//     public function validation()
// {
//    $validator= new Validation();
//    $uValidator = new UniquenessValidator(["message" => "this E-Mail has already been chosen"]);
//    $validator->add('Email', $uValidator);
//    return $this->validate($validator);
// }

  public function inintialize()
  {
//    $this->hasOne("e_mail","museum_goers","Cilent_E-mail");
//    $this->hasManyToMany("e_mail","students","Students_E-mail","Class_Name","art_class","Name",[
//     'foreignKey' => [
//         'action' => Relation::ACTION_CASCADE,
//     ]
// ]);
  }
}