<?php
namespace controllers\crud\events;

use models\Organization;
use Ubiquity\controllers\crud\CRUDEvents;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
  * Class CrudUsersEvents
  */
class CrudUsersEvents extends CRUDEvents{
	public function onBeforeUpdate(object $instance, bool $isNew) {
		//$orga=DAO::getById(Organization::class,USession::get('idOrga'));
		//$instance->setOrganization($orga);
	}

	public function onBeforeUpdateRequest(array &$requestValues, bool $isNew) {
		$requestValues['idOrganization']=USession::get('idOrga');
	}


}
