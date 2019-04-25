<?php

class lendController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
   } 
	 	

  public function indexAction(){

		$this->checkStudent();

		$lineitems = array();
    if ($this->session->has('cart')) {
		$cart = $this->session->get('cart');
		// $lineitems = array();
		foreach ($cart as $seleq => $qty) {
      $lineitem['equip'] = equip::findFirst("Equip_id ='$seleq'");
			$lineitem['qty'] = $qty;
      $lineitems[] = $lineitem;
		}
		$this->view->lineitems = $lineitems;
	}
	else {
		$this->flashSession->error("There are no items in your cart");
		$this->view->lineitems = $lineitems;
		// $this->dispatcher->forward(['controller' => "equip",'' => '']);
	}

  }

  public function emptyCartAction(){

		$this->checkStudent();

    $this->session->remove('cart');
    $this->response->redirect('lend');
	}
	
	public function deleteAction(){

		$seleq=$this->request->getPost('eqid');

    $equip = equip::findFirst("Equip_id = '$seleq'");

    if ($this->session->has('cart')){
			$cart = $this->session->get('cart');
			$key = array_search($seleq,$cart);
      if (isset($cart[$seleq])){
        unset($cart[$seleq][$key]);
      }
    }
		$this->session->set('cart',$cart); // make the cart a session variable
		
		$this->response->redirect('lend');
}

  public function requestAction(){

		if($this->session->has('studentID')){
			$request = new request();
			$requestdate = date("Y-m-d H:i:s"); 
			$getstdid=$this->session->get('studentID');

			$request->Request_date=$requestdate;
			$request->Student_id=$getstdid;
			$request->save();

			$requistid = $request->getId();

			$equipid = $this->request->getPost("equip");
			$equipnum = $this->request->getPost("eqnum");
			
			for($i=0;$i<sizeof($equipnum);$i++) {

				$cureqid = $equipid[$i];
				$cureqqty = $equipnum[$i];

				$requestdetail = new request_detail();
				$requestdetail->Equip_Num=$equipnum[$i];
				$requestdetail->Equip_id=$equipid[$i];
				$requestdetail->Request_id=$requistid;
				$requestdetail->save();

				$equip = equip::findFirst("Equip_id = '$cureqid'");
				$preqty = $equip->Equip_Num;
				$postqty = $preqty - $cureqqty;
				$equip->Equip_Num = $postqty;

				$equip->save();

			}
			$this->session->remove('cart');
			$this->flashSession->success("The Order has been placed");
			$this->response->redirect('equip');

		}else{
			$this->response->redirect('profile');
		}

	}
  

}