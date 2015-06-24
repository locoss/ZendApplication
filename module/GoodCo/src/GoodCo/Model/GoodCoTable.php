<?php
namespace GoodCo\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;


class GoodCoTable extends AbstractTableGateway {

	protected $table = 'goodco';

	public function __construct(Adapter $adapter) {
		$this->adapter = $adapter;
	}
	
	public function fetchAll() {
		$resultSet = $this->select(function (Select $select) {
			$select->order('created ASC');
		});
		$entities = array();
		foreach ($resultSet as $row) {
			$entity = new Entity\GoodCo();
			$entity->setId($row->id)
					->setNote($row->note)
					->setCreated($row->created);
			$entities[] = $entity;
		}
		return $entities;
	}
	
	public function getGoodCo($id) {
		$row = $this->select(array('id' => (int) $id))->current();
		if (!$row)
			return false;
	
		$goodCo = new Entity\GoodCo(array(
				'id' => $row->id,
				'note' => $row->note,
				'created' => $row->created,
		));
		return $goodCo;
	}
	
	public function saveGoodCo(Entity\GoodCo $goodCo) {
		$data = array(
				'note' => $goodCo->getNote(),
				'created' => $goodCo->getCreated(),
		);
	
		$id = (int) $goodCo->getId();
	
		if ($id == 0) {
			$data['created'] = date("Y-m-d H:i:s");
			if (!$this->insert($data))
				return false;
			return $this->getLastInsertValue();
		}
		elseif ($this->getGoodCo($id)) {
			if (!$this->update($data, array('id' => $id)))
				return false;
			return $id;
		}
		else
			return false;
	}
	
	public function removeGoodCo($id) {
		return $this->delete(array('id' => (int) $id));
	}
}