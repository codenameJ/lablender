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

  $lab=lab::find();
  $this->view->sentlab=$lab;

  if($this->session->has('studentID')){
    $this->flashSession->error('you cannot access this site');
    $this->response->redirect('equip');
  }else{
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

public function editAction(){

  $lab=lab::find();
  $this->view->sentlab=$lab;


if($this->session->has('studentID')){
    $this->flashSession->error('you cannot access this site');
    $this->response->redirect('equip');
  }else{
  $geteqid=$this->request->get('eqid');
  $editeq=equip::findFirst("Equip_id = '$geteqid'");
  $this->view->sentediteq=$editeq;

  if($this->request->isPost()){

    // $eqid=trim($this->request->getPost('eqid'));
    $eqname=trim($this->request->getPost('eqname'));
    $eqnum=trim($this->request->getPost('eqnum'));
    $labid=trim($this->request->getPost('labid'));

    // $editeq->Equip_id=$eqid;
    $editeq->Equip_Name=$eqname;
    $editeq->Equip_Num=$eqnum;
    $editeq->Lab_id=$labid;

    $editeq->save();

    $this->response->redirect('equip');
  }
}
}

public function deleteAction(){

  if($this->session->has('studentID')){
    $this->flashSession->error('you cannot access this site');
    $this->response->redirect('equip');
  }else{

  $geteqid=$this->request->get('eqid');
  $delequip=equip::findFirst("Equip_id = '$geteqid'");
  $delequip->delete();

  $this->response->redirect('equip');
  }
}

}