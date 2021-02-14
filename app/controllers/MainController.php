<?php
namespace controllers;
 use Ajax\service\JArray;
 use models\Groupe;
 use models\Organization;
 use models\User;
 use services\dao\OrgaRepository;
 use services\ui\UIGroups;
 use Ubiquity\attributes\items\di\Autowired;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\controllers\Router;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;

 /**
  * Controller MainController
  */
class MainController extends ControllerBase{
	use WithAuthTrait;

	#[Autowired]
	private OrgaRepository $repo;
	private UIGroups $ui;

	private function showMessage(string $header, string $message, string $type = '', string $icon = 'info circle',array $buttons=[]) {
		$this->jquery->renderView('main/vMessage.html', compact('header', 'type', 'icon', 'message','buttons'));
	}

	public function initialize() {
		$this->ui=new UIGroups($this);
		parent::initialize();
	}

	#[Route('_default',name: 'home')]
	public function index(){
		$u=$this->_getAuthController()->_getActiveUser();
		$orga=$this->repo->byId($u->getOrganization(),true,false,'orga');
		$this->ui->index($orga);
		$this->jquery->renderView("MainController/index.html");
	}

	protected function getAuthController(): AuthController {
		return new MyAuth($this);
	}

	/**
	 * @return OrgaRepository
	 */
	public function getRepo(): OrgaRepository {
		return $this->repo;
	}

	/**
	 * @param OrgaRepository $repo
	 */
	public function setRepo(OrgaRepository $repo): void {
		$this->repo = $repo;
	}

	#[Get('new/user', name: 'new.user')]
	public function newUser(){
		$this->ui->newUser();
		$this->jquery->renderView('MainController/newUser.html');
	}

	#[Get('new/users', name: 'new.users')]
	public function newUsers(){
		$this->ui->newUsers();
		$this->jquery->renderView('MainController/newUsers.html');
	}

	#[Post('new/user', name: 'new.userPost')]
	public function newUserPost(){
		$idOrga=USession::get('idOrga');
		$orga=DAO::getById(Organization::class,$idOrga,false);
		$user=new User();
		URequest::setValuesToObject($user);
		$user->setEmail(strtolower($user->getFirstname().'.'.$user->getLastname().'@'.$orga->getDomain()));
		$user->setOrganization($orga);
		if(DAO::insert($user)){
			$count=DAO::count(User::class,'idOrganization= ?',[$idOrga]);
			$this->jquery->execAtLast('$("#users-count").html("'.$count.'")');
			$this->showMessage("Ajout d'utilisateur","L'utilisateur $user a été ajouté à l'organisation.",'success','check square outline');
		}else{
			$this->showMessage("Ajout d'utilisateur","Aucun utilisateur n'a été ajouté",'error','warning circle');
		}
	}

	#[Post('new/users', name: 'new.usersPost')]
	public function newUsersPost(){
		$idOrga=USession::get('idOrga');
		$orga=DAO::getById(Organization::class,$idOrga,false);
		$us=explode("\n",URequest::post('users'));
		$newCount=0;
		DAO::beginTransaction();
		foreach ($us as $u) {
			list($firstname,$lastname)=explode(' ',$u);
			$user = new User();
			$user->setFirstname($firstname);
			$user->setLastname($lastname);
			$user->setEmail(strtolower($firstname . '.' . $lastname . '@' . $orga->getDomain()));
			$user->setOrganization($orga);
			DAO::save($user);
			$newCount++;
		}
		if (DAO::commit()) {
			$count = DAO::count(User::class, 'idOrganization= ?', [$idOrga]);
			$this->jquery->execAtLast('$("#users-count").html("' . $count . '")');
			$this->showMessage("Ajout d'utilisateurs", "$newCount utilisateur(s) ajouté(s) à l'organisation.", 'success', 'check square outline');
		} else {
			$this->showMessage("Ajout d'utilisateurs", "Aucun utilisateur n'a été ajouté", 'error', 'warning circle');
		}
	}

	#[Get('new/group', name: 'new.group')]
	public function newGroup(){
		$this->ui->newGroup();
		$this->jquery->renderView('MainController/newGroup.html');
	}

	#[Get('groups/addTo/{groupId}',name:'groups.addTo')]
	public function addToGroups($groupId){
		$idOrga=USession::get('idOrga');
		$group=DAO::getById(Groupe::class,$groupId,['users']);
		$grpUsers=$group->getUsers();
		if($grpUsers) {
			$idUsers = [];
			foreach ($grpUsers as $u) {
				$idUsers[] = $u->getId();
			}
			$w = \str_repeat('?,', \count($idUsers) - 1) . '?';
			$idUsers[]=$idOrga;
			$users = DAO::getAll(User::class, "id not in ($w) AND idOrganization= ?", false, $idUsers);
		}else{
			$users = DAO::getAll(User::class, "idOrganization= ?", false, [$idOrga]);
		}
		$this->ui->addToGroups($group,$users,$groupId);
		echo $this->jquery->compile($this->view);
	}

	#[Post('groups/addTo',name:'groups.addToPost')]
	public function addToGroupsPost(){
		$group=DAO::getById(Groupe::class,URequest::post('idGroup'),['users']);
		$idUsers=explode(',',URequest::post('users'));
		$users=DAO::getAllByIds(User::class,$idUsers);
		$oldUsers=$group->getUsers()??[];
		$users=array_merge($oldUsers,$users);
		$group->setUsers($users);
		DAO::beginTransaction();
		DAO::save($group,true);
		if(DAO::commit()){
			$this->showMessage('Ajout au groupe',"Le groupe $group comporte maintenant ".count($users)." utilisateurs.<br>".count($idUsers).' ont été ajoutés.','success','check square outline');
		}else{
			$this->showMessage('Ajout au groupe',"Aucun utilisateur ajouté au groupe ".$group,'error','warning circle');
		}
	}
}
