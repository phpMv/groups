<?php
namespace controllers\crud\datas;

use controllers\MyAuth;
use Ubiquity\controllers\crud\CRUDDatas;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
  * Class CrudUsersDatas
  */
class CrudUsersDatas extends CRUDDatas{
	public function getFieldNames($model) {
		return ['firstname','lastname','email','suspended','groupes'];
	}

	public function getFormFieldNames($model,$instance) {
		return ['firstname','lastname','email','suspended','groupes'];
	}

	public function _getInstancesFilter($model) {
		return 'idOrganization='.USession::get('idOrga');
	}

	public function getManyToManyDatas($fkClass, $instance, $member) {
		return DAO::getAll ( $fkClass, "idOrganization=".USession::get('idOrga'), false );
	}

}
