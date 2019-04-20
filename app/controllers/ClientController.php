<?php
use Phalcon\Mvc\View;
use Phalcon\Http\Request;
use Phalcon\Flash\Session as FlashSession;
 
class ClientController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
	  $this->checkAdmin();
   } 
	 	

  public function indexAction(){
        $client=client::find();
        $this->view->sentclient=$client;
    }

    public function studentAction(){

        $student=students::find();
        $this->view->sentstd=$student;
    }

    public function taAction(){

        $ta=ta::find();
        $this->view->sentta=$ta;
    }

   public function addstdAction(){

        if($this->request->isPost()){

            $email=trim($this->request->getPost('email'));
            $pass=trim($this->request->getPost('psw'));
            $name=trim($this->request->getPost('fname'));
            $stdid=trim($this->request->getPost('studentid'));
            $tel=trim($this->request->getPost('tel'));

            $checkid = students::findFirst("Student_id = '$stdid'");
            $checkemail=client::findFirst("Email = '$email'");

            if($checkemail){
                $this->flashSession->error("E-Mail exist");
              }else{
                if($checkid){
                  $this->flashSession->error("student id exist");
                  }
                  else{

            //client
      
            $member=new client();
            $member->Email=$email;
            $member->Password=$this->security->hash($pass);
            $member->Name=$name;
            $member->Phone=$tel;
      
            $member->save();

            //student

            $selclient=client::findFirst("Name = '$name'");

            $student= new students();

            $student->client_id=$selclient->client_id;
            $student->Student_id=$stdid;
            $student->Student_Name=$name;

            //save studnent
            $student->save();

            $this->response->redirect('client/student');
            }
          }
        }

    }

    public function addtaAction(){
        
        $lab=lab::find();
        $this->view->sentlab=$lab;

        if($this->request->isPost()){

            $email=trim($this->request->getPost('email'));
            $pass=trim($this->request->getPost('psw'));
            $name=trim($this->request->getPost('fname'));
            $tel=trim($this->request->getPost('tel'));
            $labid=trim($this->request->getPost('labid'));

            $checkemail=client::findFirst("Email = '$email'");

            //client
      
            if($checkemail){
                $this->flashSession->error("E-Mail exist");
            }else{
            $member=new client();
            $member->Email=$email;
            $member->Password=$this->security->hash($pass);
            $member->Name=$name;
            $member->Phone=$tel;
      
            $member->save();

            //TA

            $selclient=client::findFirst("Name = '$name'");

            $ta= new ta();

            $ta->client_id=$selclient->client_id;
            $ta->TA_Name=$name;
            $ta->Lab_id=$labid;

            //save ta
            $ta->save();

            $this->response->redirect('client/ta');
            }
          }

    }
    
    public function editstdAction(){

        $getclid=$this->request->get('id');
        $editcli=client::findFirst("client_id = '$getclid'");
        $this->view->editclient=$editcli;

        $editstd=students::findFirst("client_id = '$editcli->client_id'");
        $this->view->senteditstd=$editstd;
        
        if($this->request->isPost()){

            // $editstdid=trim($this->request->getPost('stdid'));
            $editname=trim($this->request->getPost('name'));
            $editemail=trim($this->request->getPost('email'));
            $editphone=trim($this->request->getPost('phone'));
            $editactivate=trim($this->request->getPost('activate'));


            $checkemail=client::findFirst("Email = '$email'");

            if($checkemail){
                $this->flashSession->error("E-Mail exist");
            }else{
            
            $editcli->Name=$editname;
            $editcli->Email=$editemail;
            $editcli->Phone=$editphone;
            $editcli->Activation=$editactivate;
      
            $editcli->save();
      
            // $editstd->Student_id=$editstdid;
            $editstd->Student_Name=$editname;
      
            $editstd->save();

            $this->response->redirect('client/student');
            }
        }
        
    }

    public function edittaAction(){

        $getclid=$this->request->get('id');
        $editcli=client::findFirst("client_id = '$getclid'");
        $this->view->editclient=$editcli;

        $editta=ta::findFirst("client_id = '$editcli->client_id'");
        $this->view->senteditta=$editta;
        
        $lab=lab::find();
        $this->view->sentlab=$lab;

        if($this->request->isPost()){

            $editname=trim($this->request->getPost('name'));
            $editemail=trim($this->request->getPost('email'));
            $editphone=trim($this->request->getPost('phone'));
            $editactivate=trim($this->request->getPost('activate'));
            $editlab=trim($this->request->getPost('lab'));

            $checkemail=client::findFirst("Email = '$email'");

            if($checkemail){
                $this->flashSession->error("E-Mail exist");
            }else{


            $editcli->Name=$editname;
            $editcli->Email=$editemail;
            $editcli->Phone=$editphone;
            $editcli->Activation=$editactivate;
      
            $editcli->save();
      
            $editta->TA_Name=$editname;
            $editta->Lab_id=$editlab;
      
            $editta->save();
      

            $this->response->redirect('client/ta');
            }
        }
        
    }
    
    public function deletestdAction(){

        $getclid=$this->request->get('id');
        $editcli=client::findFirst("client_id = '$getclid'");
        
        $editcli->delete();

        $this->response->redirect('client/student');

    }

    public function deletetaAction(){

        $getclid=$this->request->get('id');
        $editcli=client::findFirst("client_id = '$getclid'");
        
        $editcli->delete();

        $this->response->redirect('client/ta');

    } 

}
