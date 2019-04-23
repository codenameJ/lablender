<?php

class CheckrequestController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
   } 
	 	

  public function indexAction(){

    $request=request::find();
    $this->view->sentrq = $request;
    
  }

  public function waitAction(){

    $request=request::find();
    $this->view->sentrq = $request;

}

  public function readyAction(){

    $request=request::find();
    $this->view->sentrq = $request;
    
  }

  public function reciveAction(){

    $request=request::find();
    $this->view->sentrq = $request;
    
  }

  public function saveAction(){

      $getrqid=trim($this->request->getPost('rqid'));
      $selrqid=request::findFirst("request_id = '$getrqid'");
      $getstatus=trim($this->request->getPost('status'));
    

      $selrqid->status=$getstatus;
      $selrqid->save();

      $this->response->redirect('checkrequest');

  }
  
public function deleteAction(){

    $getrqid=$this->request->get('rqid');
    $delerqip=request::findFirst("request_id = '$getrqid'");
    $delerqip->delete();
  $this->response->redirect('checkrequest');
  }
}
