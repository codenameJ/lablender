<?php

class requestController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
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
    $delerqip->delete();
  $this->response->redirect('request');
  }else{
    $this->flashSession->error('you cannot access this site');
    $this->response->redirect('page-top');
  }
}

}