<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudGroupsFiles
  */
class CrudGroupsFiles extends CRUDFiles{
	public function getViewIndex(){
		return "CrudGroups/index.html";
	}

	public function getViewForm(){
		return "CrudGroups/form.html";
	}

	public function getViewDisplay(){
		return "CrudGroups/display.html";
	}


}
