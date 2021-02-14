<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\OneToMany;

#[Table(name: "settings")]
class Settings{
	
	#[Id()]
	#[Column(name: "id",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "name",nullable: true,dbType: "varchar(45)")]
	#[Validator(type: "length",constraints: ["max"=>45])]
	private $name;

	
	#[OneToMany(mappedBy: "settings",className: "models\\Organizationsettings")]
	private $organizationsettingss;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name=$name;
	}

	public function getOrganizationsettingss(){
		return $this->organizationsettingss;
	}

	public function setOrganizationsettingss($organizationsettingss){
		$this->organizationsettingss=$organizationsettingss;
	}

	 public function addOrganizationsettings($organizationsettings){
		$this->organizationsettingss[]=$organizationsettings;
	}

	 public function __toString(){
		return $this->id.'';
	}

}