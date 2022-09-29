<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class MyAuthFiles
  */
class MyAuthFiles extends AuthFiles{
	public function getViewIndex():string{
		return "MyAuth/index.html";
	}

	public function getViewInfo():string{
		return "MyAuth/info.html";
	}

	public function getViewNoAccess():string{
		return "MyAuth/noAccess.html";
	}

	public function getViewDisconnected():string{
		return "MyAuth/disconnected.html";
	}

	public function getViewMessage():string{
		return "MyAuth/message.html";
	}

	public function getViewBaseTemplate():string{
		return "MyAuth/baseTemplate.html";
	}


}
