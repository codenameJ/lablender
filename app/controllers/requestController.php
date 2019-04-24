<?php

class requestController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
    $this->CheckAuthen();
    $this->CheckStudent();
   } 
	 	

  public function indexAction(){

    $getstdid=$this->session->get('studentID');
    $stdrequest=request::find("Student_id = '$getstdid'");

    $this->view->sentstdrq = $stdrequest;

  }
  
public function deleteAction(){

  if($this->session->has('studentID')){
    $getrqid=$this->request->get('rqid');
    $delerqip=request::findFirst("request_id = '$getrqid'");

    $rqdetail = request_detail::find("Request_id = '$getrqid'");

    foreach($rqdetail as $row){
      $equip = equip::findFirst("Equip_id = '$row->Equip_id'");
      $lendqty = $row->Equip_Num;
      $curqty = $equip->Equip_Num;
      $reqty = $lendqty+$curqty;

      $equip->Equip_Num = $reqty;

      $equip->save();
    }

    $delerqip->delete();
  $this->response->redirect('request');
  }else{
    $this->flashSession->error('you cannot access this site');
    $this->response->redirect('page-top');
  }
}

public function receiveAction(){

  $getrqid=trim($this->request->getPost('rqid'));
  $selrqid=request::findFirst("request_id = '$getrqid'");
  $getreceive=trim($this->request->getPost('receive'));

  $selrqid->status=$getreceive;
  $selrqid->save();

  $receivedate = date("Y-m-d H:i:s"); 

  $receivehis = new history();

  $receivehis->request_id = $selrqid->request_id;
  $receivehis->student_id = $selrqid->Student_id;
  $receivehis->request_date = $selrqid->Request_date;
  $receivehis->receive_date = $receivedate;

  $receivehis->save();

  $this->response->redirect('request');
}

}