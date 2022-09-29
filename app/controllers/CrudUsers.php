<?php
namespace controllers;
use controllers\crud\datas\CrudUsersDatas;
use Ubiquity\controllers\crud\CRUDDatas;
use controllers\crud\viewers\CrudUsersViewer;
use Ubiquity\controllers\crud\viewers\ModelViewer;
use controllers\crud\events\CrudUsersEvents;
use Ubiquity\controllers\crud\CRUDEvents;
use controllers\crud\files\CrudUsersFiles;
use Ubiquity\controllers\crud\CRUDFiles;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/users",inherited: true,automated: true)]
class CrudUsers extends \Ubiquity\controllers\crud\CRUDController{

	public function __construct(){
		parent::__construct();
		\Ubiquity\orm\DAO::start();
		$this->model='models\\User';
		$this->style='';
	}

	public function initialize() {
		parent::initialize();
		$this->jquery->show('#back-to-index','','',true);
	}

	public function _getBaseRoute():string {
		return '/users';
	}
	
	protected function getAdminData(): CRUDDatas{
		return new CrudUsersDatas($this);
	}

	protected function getModelViewer(): ModelViewer{
		return new CrudUsersViewer($this,$this->style);
	}

	protected function getEvents(): CRUDEvents{
		return new CrudUsersEvents($this);
	}

	protected function getFiles(): CRUDFiles{
		return new CrudUsersFiles();
	}

}
