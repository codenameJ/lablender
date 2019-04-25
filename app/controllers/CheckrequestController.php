<?php

class CheckrequestController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
    $this->CheckAuthen();
    $this->checkTa();
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

  public function receiveAction(){

    $request=request::find();
    $this->view->sentrq = $request;
    
  }

  public function saveAction(){

      $getrqid=trim($this->request->getPost('rqid'));
      $selrqid=request::findFirst("request_id = '$getrqid'");
      $getstatus=trim($this->request->getPost('status'));
    

      $selrqid->status=$getstatus;
      $selrqid->save();

      if($getstatus === "3"){

        $receivedate = date("Y-m-d H:i:s"); 

        $receivehis = new history();

        $receivehis->request_id = $selrqid->request_id;
        $receivehis->student_id = $selrqid->Student_id;
        $receivehis->request_date = $selrqid->Request_date;
        $receivehis->receive_date = $receivedate;

        $receivehis->save();
      }

      $this->response->redirect('checkrequest');

  }
  
public function deleteAction(){

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



  $this->response->redirect('checkrequest');
  }
}
