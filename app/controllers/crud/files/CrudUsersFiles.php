<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudUsersFiles
  */
class CrudUsersFiles extends CRUDFiles{
	public function getViewIndex(){
		return "CrudUsers/index.html";
	}

	public function getViewForm(){
		return "CrudUsers/form.html";
	}

	public function getViewDisplay(){
		return "CrudUsers/display.html";
	}


}
