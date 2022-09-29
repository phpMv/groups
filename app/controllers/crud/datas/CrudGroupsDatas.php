<?php
namespace controllers\crud\datas;

use Ubiquity\controllers\crud\CRUDDatas;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
  * Class CrudGroupsDatas
  */
class CrudGroupsDatas extends CRUDDatas{
	public function _getInstancesFilter($model):string {
		return 'idOrganization='.USession::get('idOrga');
	}
	public function getManyToManyDatas($fkClass, $instance, $member):array {
		return DAO::getAll ( $fkClass, "idOrganization=".USession::get('idOrga'), false );
	}

	public function getFieldNames($model):array {
		return ['name','email','users'];
	}

	public function getFormFieldNames($model, $instance):array {
		return ['name','email','aliases','users'];
	}

	public function getElementFieldNames($model):array {
		return ['name','email','aliases','users'];
	}


}
