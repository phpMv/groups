<?php
namespace controllers\crud\viewers;

use Ajax\semantic\html\elements\HtmlLabel;
use Ubiquity\controllers\crud\viewers\ModelViewer;
 /**
  * Class CrudGroupsViewer
  */
class CrudGroupsViewer extends ModelViewer{
	protected function getDataTableRowButtons() {
		return [ 'display','edit','delete' ];
	}
	private function updateWidgetFields($widget){
		$widget->setValueFunction('users',function($v,$instance){
			$lbl=new HtmlLabel('lbl-'.$instance->getId(),\count($v??[]));
			$lbl->addClass('');
			$lbl->addIcon('users',true,true);
			return $lbl;
		});
	}
	public function getForm($identifier, $instance, $updateUrl = 'updateModel') {
		$res=parent::getForm($identifier,$instance,$updateUrl);
		$res->fieldAsHidden('id');
		$res->fieldAsHidden('idOrganization');
		return $res;
	}

	public function getModelDataTable($instances, $model, $totalCount, $page = 1) {
		$res= parent::getModelDataTable($instances, $model, $totalCount, $page);
		$this->updateWidgetFields($res);
		return $res;
	}

	public function getModelDataElement($instance, $model, $modal) {
		$res= parent::getModelDataElement($instance, $model, $modal);
		$this->updateWidgetFields($res);
		return $res;
	}
}
