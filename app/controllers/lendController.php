<?php

class lendController extends ControllerBase {

   public function beforeExecuteRoute(){ // function ที่ทำงานก่อนเริ่มการทำงานของระบบทั้งระบบ
		$this->CheckAuthen();
   } 
	 	

  public function indexAction(){

        if ($this->session->has('cart')) {
		$cart = $this->session->get('cart');
        $lineitems = array();
		foreach ($cart as $seleq => $qty) {
            $lineitem['equip'] = equip::findFirst("Equip_id ='$seleq'");
			$lineitem['qty'] = $qty;
            $lineitems[] = $lineitem;
		}
		$this->view->lineitems = $lineitems;
	}
	else {
		$this->flash->error("There are no items in your cart");
		$this->dispatcher->forward(['controller' => "equip",'action' => 'index']);
	}

  }

  public function emptyCartAction(){
    $this->session->remove('cart');
    $this->response->redirect('lend');
  }

  public function checkOutAction(){

    // if ($this->session->has('cart')) {
	// 	$cart = $this->session->get('cart');
	// 	$lineitems = array();
	// 	foreach ($cart as $seleq => $qty) {
	// 		$lineitem['product'] = equip::findFirstByid($seleq);
	// 		$lineitem['qty'] = $qty;
	// 		$lineitems[] = $lineitem;
	// 	}
	// 	$this->view->lineitems = $lineitems;
	// }
	// else {
	// 	$this->flash->error("There are no items in your cart");
	// 	$this->dispatcher->forward(['controller' => "product",'action' => 'displayGrid']);
	// }
}
  

}