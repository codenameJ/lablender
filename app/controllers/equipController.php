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

public function addAction(){

  if($this->request->isPost()){

    $eqid=trim($this->request->getPost('eqid'));
    $eqname=trim($this->request->getPost('eqname'));
    $eqnum=trim($this->request->getPost('eqnum'));
    $labid=trim($this->request->getPost('labid'));

    $equip=new equip();
    $equip->Equip_id=$eqid;
    $equip->Equip_Name=$eqname;
    $equip->Equip_Num=$eqnum;
    $equip->Lab_id=$labid;

    $equip->save();

    $this->response->redirect('equip');
  }
}
}