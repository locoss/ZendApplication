<?php
namespace GoodCo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GoodCoController extends AbstractActionController {
	protected $_goodCoTable;
	
	
	public function getGoodCoTable() {
		if (!$this->_getGoodCoTable) {
			$sm = $this->getServiceLocator();
			$this->_getGoodCoTable = $sm->get('GoodCo\Model\GoodCoTable');
		}
		return $this->_goodCoTable;
	}
	
	public function indexAction() {
		return new ViewModel(array(
				'goodcos' => $this->getGoodCoTable()->fetchAll(),
		));
	}

	public function addAction(){
		$request = $this->getRequest();
		$response = $this->getResponse();
		if ($request->isPost()) {
			$new_note = new \GoodCo\Model\Entity\GoodCo();
			if (!$note_id = $this->getGoodCoTable()->saveGoodCo($new_note))
				$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
			else {
				$response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
			}
		}
		return $response;
	}

	public function removeAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		if ($request->isPost()) {
			$post_data = $request->getPost();
			$note_id = $post_data['id'];
			if (!$this->getGoodCoTable()->removeGoodCo($note_id))
				$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
			else {
				$response->setContent(\Zend\Json\Json::encode(array('response' => true)));
			}
		}
		return $response;
	}

	public function updateAction(){
		$request = $this->getRequest();
		$response = $this->getResponse();
		if ($request->isPost()) {
			$post_data = $request->getPost();
			$note_id = $post_data['id'];
			$note_content = $post_data['content'];
			$goodco = $this->getGoodCoTable()->getGoodCo($note_id);
			$goodco->setNote($note_content);
			if (!$this->getGoodCoTable()->saveGoodCo($goodco))
				$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
			else {
				$response->setContent(\Zend\Json\Json::encode(array('response' => true)));
			}
		}
		return $response;
	}
	
	
	
	
}