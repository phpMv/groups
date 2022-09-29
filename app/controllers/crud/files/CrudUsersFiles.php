<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudUsersFiles
  */
class CrudUsersFiles extends CRUDFiles{
	public function getViewIndex():string{
		return "CrudUsers/index.html";
	}

	public function getViewForm():string{
		return "CrudUsers/form.html";
	}

	public function getViewDisplay():string{
		return "CrudUsers/display.html";
	}


}
