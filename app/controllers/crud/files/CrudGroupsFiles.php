<?php
namespace controllers\crud\files;

use Ubiquity\controllers\crud\CRUDFiles;
 /**
  * Class CrudGroupsFiles
  */
class CrudGroupsFiles extends CRUDFiles{
	public function getViewIndex():string{
		return "CrudGroups/index.html";
	}

	public function getViewForm():string{
		return "CrudGroups/form.html";
	}

	public function getViewDisplay():string{
		return "CrudGroups/display.html";
	}


}
