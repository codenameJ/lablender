<?php

class equipController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
   } 
	 	

  public function indexAction(){
    $equip  = equip::find();
    $this->view->sentdata = $equip;
  }
  
  public function lendAction(){

    $seleq=$this->request->get('eqid');
    $eq=equip::findFirst("Equip_id = '$seleq'");

    $idstd=$this->session->get('memberID');
    $std=client::findFirst("ID = '$idstd'");


    if($this->request->isPost()){

      $seleq=$this->request->get('eqid');
      $eq=equip::findFirst("Equip_id = '$seleq'");
  
      $idstd=$this->session->get('memberID');
      $std=client::findFirst("ID = '$idstd'");

      $lendeq=new lend_equip();

      $lendeq->Student_id=$idstd;
      $lendeq->Student_Name=$std->Name;
      $lendeq->Equip_id=$seleq;

      $lendeq->save();

    }else
    $this->response->redirect('page-top');

}
}