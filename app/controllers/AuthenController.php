<?php
use Phalcon\Mvc\View;
use Phalcon\Http\Request;
use Phalcon\Flash\Session as FlashSession;

class AuthenController extends ControllerBase {

  public function indexAction(){
    $this->response->redirect('authen/login');
     }

  public function logInAction(){

    if($this->session->has('memberID')){
      $this->response->redirect('authen/notactivate');
    }

    if($this->session->has('memberAuthen')){
      $this->response->redirect('profile');
    }

    if($this->request->isPost()){
      $email=trim($this->request->getPost('email'));
      $pass=trim($this->request->getPost('pass'));
      $rememberMe = $this->request->getPost('rememberMe'); // รับค่าจาก form

      $member=client::findFirst("Email = '$email'");
      $student=students::findFirst("client_id ='$member->client_id'");
      $ta=ta::findFirst("client_id = '$member->client_id'");

      if($member){
          if($this->security->checkHash($pass, $member->Password)){ // ตรวจสอบรหัสด้วย key การเข้ารหัส

            if($member->Activation === 'Yes'){

              if($member->Email === "admin@lablender"){
              $this->session->set('memberAuthen', $member->Name);
              $this->session->set('memberEmail', $member->Email);
              $this->session->set('memberID', $member->client_id);
              $this->session->set('IsAdmin','Admin');
              $this->response->redirect('admin');
              }
              if($student){
              $this->session->set('memberAuthen', $member->Name);
              $this->session->set('memberEmail', $member->Email);
              $this->session->set('memberID', $member->client_id);
              $this->session->set('studentID', $student->Student_id);
              $this->response->redirect('equip');
              }
              if($ta){
                  $this->session->set('memberAuthen', $member->Name);
                  $this->session->set('memberEmail', $member->Email);
                  $this->session->set('memberID', $member->client_id);
                  $this->session->set('taID', $ta->TA_id);
                  $this->response->redirect('profile');
              }  
            }
            else{
            $this->session->set('memberID', $member->client_id);
            $this->response->redirect('authen/notactivate');
            }

            if($rememberMe==1) {
              $hour = time() + 3600;
               
              $this->cookies->set('Email',$email,$hour );
              $this->cookies->set('Password',$pass,$hour );
          }else {     
              $data = $this->cookies->get('Email');
                $data->delete();
              $data = $this->cookies->get('Password');
                $data->delete();
         
           }

        }
        else{
          $this->flashSession->error('Password Incorrect'); // เก็บ error ที่แสดงไว้ใน flash
        }
        }
      else{
        $this->flashSession->error('User Not Found'); // เก็บ error ที่แสดงไว้ใน flash
      }
  }
}

  public function signUpAction(){

    if($this->session->has('memberID')){
      $this->response->redirect('authen/notactivate');
    }

    if($this->session->has('memberAuthen')){
      $this->response->redirect('profile');
    }
    
    $sentmail = new Mail();

    if($this->request->isPost()){

      // $clientid=trim($this->request->getPost('id'));
      $name=trim($this->request->getPost('name'));
      $pass=trim($this->request->getPost('pass'));
      $stdid=trim($this->request->getPost('studentid'));
      $email=trim($this->request->getPost('email'));
      $phone=trim($this->request->getPost('phoneno'));

      $checkid=students::findFirst("Student_id = '$stdid'");
      $checkemail=client::findFirst("Email = '$email'");

      if($checkemail){
        $this->flashSession->error("E-Mail exist");
      }else{
        if($checkid){
          $this->flashSession->error("student id exist");
          }
          else{
          //add client
          $client=new client();

          $client->Name=$name;
          $client->Email=$email;
          $client->Password=$this->security->hash($pass);
          $client->Phone=$phone;

          //save client
          $client->save();

          $selclient=client::findFirst("Name = '$name'");

          //add student
          $student= new students();

          $student->client_id=$selclient->client_id;
          $student->Student_id=$stdid;
          $student->Student_Name=$name;

          //save studnent
          $student->save();

          //Send Email
    
          $params = [
          'name' => $this->request->getPost('name'),
          'link' => "http://localhost/lablender_demo10/authen/activate?id=".$client->client_id."?"
          ];
          $sentmail->send($this->request->getPost('email'), 'signup', $params);


          $this->response->redirect('page-top');

          $this->view->disable();
          }
        }
      }

  }

  public function activateAction(){

    $AcId=$this->request->get('id');
    $curclient=client::findFirst("client_id = '$AcId'");

    if($AcId){
    
    $curclient->Activation = 'Yes';
    $curclient->save();

    }else{
      $this->response->redirect('authen/login');
    }

  }

  public function notactivateAction(){

    $this->checkid();

    $sentmail = new Mail();

    if($this->request->isPost()){
    $getclientid=$this->session->get('memberID');
    $curclient=client::findFirst("client_id = '$getclientid'");

    $params = [
      'name' => $curclient->Name,
      'link' => "http://localhost/lablender_demo10/authen/activate?id=".$curclient->client_id."?"
  ];
  $sentmail->send($curclient->Email, 'signup', $params);

  $this->session->remove('memberID');

  $this->response->redirect('authen/login');

  }

  }

  public function signOutAction(){
    $this->session->remove('memberAuthen');
    $this->session->remove('memberEmail');
    $this->session->remove('memberID');
    $this->session->remove('IsAdmin');
    $this->session->remove('studentID');
    $this->session->remove('taID');
	  $this->response->redirect('page-top');
  }

}
