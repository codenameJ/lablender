<?php
use Phalcon\Mvc\Model;
class equip extends Model{

    public $Equip_id;
    public $Equip_Name;
    public $Equip_Num;
    public $Lab_id;

  public function inintialize()
  {
//     $this->hasMany("Name","art_object","Artist_Name",[
//       'foreignKey' => [
//           'action' => Relation::ACTION_CASCADE,
//       ]
//   ]);
//     $this->hasOne("Name","alive","Artist_Name");
//     $this->hasOne("Name","died","Artist_Name");     
  }

}