<?php
use Phalcon\Mvc\View; // เรียกใช้ความสามารถของ function view
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller{
 
   
  public function initialize() { // function ที่จะถูกเรียนใช้งานก่อนทุกครั้ง ที่เริ่มระบบ
  

    $this->assets
      ->collection('styles') // pack ไฟล์ css ที่ต้องการใช้งาน

      ->addCss('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700')
      ->addCss('public/css/animate.css')
      ->addCss('public/css/icomoon.css')
      ->addCss('public/css/flexslider.css') 
      ->addCss('public/css/style.css')
      ->addCss('public/css/bootstrap.css');
      
    $this->assets
      ->collection('scripts') // pack ไฟล์ js ที่ต้องการใช้งาน
      ->addJs('public/js/modernizr-2.6.2.min.js')
      ->addJs('public/js/jquery.min.js')
      ->addCss('public/js/bootstrap.min.js')
      ->addJs('public/js/jquery.easing.1.3.js')
      ->addJs('public/js/jquery.waypoints.min.js')
      ->addJs('public/js/jquery.flexslider-min.js')
      ->addJs('public/js/main.js');


      $this->assets
      ->collection('styleslogin') // pack ไฟล์ css ที่ต้องการใช้งาน
      ->addCss('public/vendor/login/bootstrap/css/bootstrap.min.css')
      ->addCss('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700')
      ->addCss('public/vendor/login/animate/animate.css')
      ->addCss('public/vendor/login/css-hamburgers/hamburgers.min.css')
      ->addCss('public/vendor/login/animsition/css/animsition.min.css')
      ->addCss('public/vendor/logon/select2/select2.min.css')
      ->addCss('public/vendor/login/daterangepicker/daterangepicker.css')
      ->addCss('public/css/login/util.css')
      ->addCss('public/css/login/main.css');

      $this->assets
      ->collection('scriptslogin')
      ->addJs('public/vendor/login/jquery/jquery-3.2.1.min.js')
      ->addJs('public/vendor/login/animsition/js/animsition.min.js')
      ->addJs('public/vendor/login/bootstrap/js/popper.js')
      ->addJs('public/vendor/login/bootstrap/js/bootstrap.min.js')
      ->addJs('public/vendor/login/select2/select2.min.js')
      ->addJs('public/vendor/login/daterangepicker/moment.min.js')
      ->addJs('public/vendor/login/daterangepicker/daterangepicker.js')
      ->addJs('public/vendor/login/countdowntime/countdowntime.js')
      ->addJs('public/js/login/main.js');







  }





  public function checkAuthen()
  {
	 if(!$this->session->has('memberAuthen')){ // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
         $this->response->redirect('authen/login');
         $this->session->remove('IsAdmin');
   }
   }

   public function checkAdmin()
   {
    if(!$this->session->has('IsAdmin')){ // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
          $this->response->redirect('page-top');
          $this->session->remove('IsAdmin');
      }
    }

  public function checkId()
  {
	 if(!$this->session->has('memberID')){ // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
         $this->response->redirect('authen/login');
   }
   }
  
  public function checkStudent()
  {
  if(!$this->session->has('studentID')){ // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
      $this->response->redirect('authen/login');
    }
  }

  public function checkTa()
  {
	 if(!$this->session->has('taID')){ // ตรวจสอบว่ามี session การเข้าระบบ หรือไม่
         $this->response->redirect('authen/login');
   }
   }
}