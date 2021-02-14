<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\ManyToOne;
use Ubiquity\attributes\items\JoinColumn;

#[Table(name: "organizationsettings")]
class Organizationsettings{
	
	#[Id()]
	#[Column(name: "idSettings",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $idSettings;

	
	#[Id()]
	#[Column(name: "idOrganization",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $idOrganization;

	
	#[Column(name: "value",nullable: true,dbType: "varchar(100)")]
	#[Validator(type: "length",constraints: ["max"=>100])]
	private $value;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\Organization",name: "idOrganization")]
	private $organization;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\Settings",name: "idSettings")]
	private $settings;

	public function getIdSettings(){
		return $this->idSettings;
	}

	public function setIdSettings($idSettings){
		$this->idSettings=$idSettings;
	}

	public function getIdOrganization(){
		return $this->idOrganization;
	}

	public function setIdOrganization($idOrganization){
		$this->idOrganization=$idOrganization;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value=$value;
	}

	public function getOrganization(){
		return $this->organization;
	}

	public function setOrganization($organization){
		$this->organization=$organization;
	}

	public function getSettings(){
		return $this->settings;
	}

	public function setSettings($settings){
		$this->settings=$settings;
	}

	 public function __toString(){
		return $this->idSettings.'';
	}

}