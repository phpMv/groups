<?php
namespace services\ui;

 use Ajax\php\ubiquity\UIService;
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

	public function newUser(){
		$frm=$this->semantic->dataForm('frmUser',new User());
		$frm->addClass('inline');
		$frm->setFields(['firstname','lastname']);
		$frm->setCaptions(['Prénom','Nom']);
		$frm->fieldAsLabeledInput('firstname',['rules'=>'empty']);
		$frm->fieldAsLabeledInput('lastname',['rules'=>'empty']);
		$frm->setValidationParams(["on"=>"blur","inline"=>true]);
		$frm->setSubmitParams(Router::path('new.userPost'),'#new-user',['hasLoader'=>'internal']);
		$this->jquery->click('#validate-btn','$("#frmUser").form("submit");');
		$this->jquery->click('#frm-user-div #cancel-btn','$("#frm-user-div").hide();');
	}

	public function newUsers(){
		$frm=$this->semantic->htmlForm('frmUsers');
		$frm->addClass('inline');
		$frm->addTextarea('users','Utilisateurs','',"Entrez chaque utilisateur sur une ligne\nJohn DOE");
		$frm->setValidationParams(["on"=>"blur","inline"=>true]);
		$frm->setSubmitParams(Router::path('new.usersPost'),'#new-users',['hasLoader'=>'internal']);
		$this->jquery->click('#frm-users-div #validate-btn','$("#frmUsers").form("submit");');
		$this->jquery->click('#frm-users-div #cancel-btn','$("#frm-users-div").hide();');
	}

	public function newGroup() {
		$frm = $this->semantic->dataForm('frmGroup', new Groupe());
		$frm->addClass('inline');
		$frm->setFields(['name']);
		$frm->setCaptions(['Nom']);
		$frm->setValidationParams(["on" => "blur", "inline" => true]);
		$frm->fieldAsLabeledInput('name', ['rules' => 'empty']);

		$this->jquery->click('#frm-group-div #cancel-btn', '$("#frm-group-div").hide();');
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
