<?php

class historyController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
    $this->CheckAuthen();
   } 
	 	

  public function indexAction(){

    $getstdid=$this->session->get('studentID');
    $stdhis=history::find("student_id = '$getstdid'");

    $this->view->senthis = $stdhis;

  }
  
  public function allAction(){

    if($this->session->has('studentID')){
      $this->response->redirect('profile');
    }else{
    $his=history::find();
    $this->view->sentallhis = $his;
    }
  }

}