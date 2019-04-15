<?php
 
class AdminController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
		$this->checkAdmin();
   } 
	 	

  public function indexAction(){
		$this->session->get('IsAdmin');
    $profileId=$this->session->get('memberEmail');
  	$profile=client::findFirst("Email = '$profileId'");
		$this->view->profile=$profile;
		$this->response->redirect('profile');
	}

}
