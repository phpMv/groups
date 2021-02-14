<?php
namespace services\ui;

 use Ajax\php\ubiquity\UIService;
 use Ajax\semantic\html\collections\form\HtmlForm;
 use Ajax\semantic\widgets\dataform\DataForm;
 use Ajax\service\JArray;
 use models\Groupe;
 use models\Organization;
 use models\User;
 use Ubiquity\controllers\Controller;
 use Ubiquity\controllers\Router;
 use Ubiquity\utils\http\URequest;

 /**
  * Class UIGroups
  */
class UIGroups extends UIService {
	public function __construct(Controller $controller) {
		parent::__construct($controller);
		if(!URequest::isAjax()) {
			$this->jquery->getHref('a[data-target]', '', ['hasLoader' => 'internal', 'historize' => false,'listenerOn'=>'body']);
		}
	}

	private function addFormBehavior(string $formName,HtmlForm|DataForm $frm,string $responseElement,string $postUrlName){
		$frm->setValidationParams(["on"=>"blur","inline"=>true]);
		$this->jquery->click("#$formName-div ._validate",'$("#'.$formName.'").form("submit");');
		$this->jquery->click("#$formName-div ._cancel",'$("#'.$formName.'-div").hide();');
		$frm->setSubmitParams(Router::path($postUrlName),'#'.$responseElement,['hasLoader'=>'internal']);
	}

	public function index(Organization $orga){
		$bt=$this->semantic->htmlDropdown('dd-groupes','',JArray::modelArray($orga->getGroupes(),'getId'));
		$bt->setAction('hide');
		$lbl=$bt->addLabel('');
		$lbl->addClass('basic inverted black')->setProperty('style','display:none')->setIdentifier('lbl-group');
		$this->jquery->getOnClick('#dd-groupes .item',Router::path('groups.addTo',['']),'#add-to-group',['hasLoader'=>'internal-x','attr'=>'data-value','stopPropagation'=>false,'preventDefault'=>false]);
		$bt->setValue('Ajouter des utilisateurs au groupe...');
		$bt->addClass('olive');
		$bt->addIcon('walking');
		$bt->asButton();
	}

	public function newUser($formName){
		$frm=$this->semantic->dataForm($formName,new User());
		$frm->addClass('inline');
		$frm->setFields(['firstname','lastname']);
		$frm->setCaptions(['Prénom','Nom']);
		$frm->fieldAsLabeledInput('firstname',['rules'=>'empty']);
		$frm->fieldAsLabeledInput('lastname',['rules'=>'empty']);
		$this->addFormBehavior($formName,$frm,'#new-user','new.userPost');
	}

	public function newUsers($formName){
		$frm=$this->semantic->htmlForm($formName);
		$frm->addClass('inline');
		$frm->addTextarea('users','Utilisateurs','',"Entrez chaque utilisateur sur une ligne\nJohn DOE")->addRules(['empty']);
		$this->addFormBehavior($formName,$frm,'new-users','new.usersPost');
	}

	public function newGroup($formName) {
		$frm = $this->semantic->dataForm($formName, new Groupe());
		$frm->addClass('inline');
		$frm->setFields(['name']);
		$frm->setCaptions(['Nom']);
		$frm->fieldAsLabeledInput('name', ['rules' => 'empty']);
		$this->addFormBehavior($formName,$frm,'new-group','new.groupPost');
	}

	public function addToGroups(Groupe $group,array $users,int $groupId){
		$this->jquery->execAtLast('$("#lbl-group").html("'.$group.'").show();');

		$frm=$this->jquery->semantic()->htmlForm('frm');
		$frm->setValidationParams(['on'=>'submit','inline'=>true]);

		$frm->addInput('idGroup','','hidden',$groupId);
		$fields=$frm->addFields();
		$fields->setInline();
		$dd=$fields->addDropdown('dd',JArray::modelArray($users,'getId'),null,'',true);
		$dd->getField()->asSearch('users',true,true)->setProperty('style','min-width:400px');
		$dd->addRule('minCount[1]');
		$bt=$fields->addButtonIcon('bt-validate','plus','positive');
		$frm->setSubmitParams(Router::path('groups.addToPost'),'#add-to-group',['hasLoader'=>'internal','jsCallback'=>'$("#lbl-group").hide();']);
		$bt=$fields->addButtonIcon('bt-cancel','remove','','$("#add-to-group").html("");$("#lbl-group").hide();');
		echo $frm;
	}
}
