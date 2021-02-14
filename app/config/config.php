<?php
return array(
	"siteUrl"=>"http://127.0.0.1:8090/",
	"database"=>[
			"type"=>"mysql",
			"dbName"=>"messagerie",
			"serverName"=>"127.0.0.1",
			"port"=>3306,
			"user"=>"root",
			"password"=>"",
			"options"=>array(),
			"cache"=>false,
			"wrapper"=>"Ubiquity\\db\\providers\\pdo\\PDOWrapper"
			],
	"sessionName"=>"s6025e0cbb0219",
	"namespaces"=>array(),
	"templateEngine"=>"Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions"=>[
			"cache"=>false
			],
	"test"=>false,
	"debug"=>true,
	"logger"=>function (){
		return new \Ubiquity\log\libraries\UMonolog(array (
  'host' => '127.0.0.1',
  'port' => 8090,
  'sessionName' => 's6025e0cbb0219',
)['sessionName'], \Monolog\Logger::INFO);
	},
	"di"=>[
			"@exec"=>array("jquery"=>function ($controller){
						return \Ubiquity\core\Framework::diSemantic($controller);
					})
			],
	"cache"=>[
			"directory"=>"cache/",
			"system"=>"Ubiquity\\cache\\system\\ArrayCache",
			"params"=>array()
			],
	"mvcNS"=>[
			"models"=>"models",
			"controllers"=>"controllers",
			"rest"=>""
			],
	"isRest"=>function (){
			return \Ubiquity\utils\http\URequest::getUrlParts()[0]==="rest";
		}
	);