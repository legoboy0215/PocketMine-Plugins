<?php

namespace queryfacade;

use pocketmine\plugin\PluginBase;
use queryfacade\command\QueryFacadeCommand;
use queryfacade\event\QueryFacadeListener;

class QueryFacadeAPI extends PluginBase{
    private $queryfacade;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
        $this->setCloakPlayerCount($this->getConfig()->getNested("query.playerCount"));
        $this->setCloakMaxPlayerCount($this->getConfig()->getNested("query.maxPlayerCount"));
        $this->setCloakPlayerList($this->getConfig()->getNested("query.playerList"));
        $this->setCloakLevel($this->getConfig()->getNested("query.level"));
        $this->setCloakPlugins($this->getConfig()->getNested("query.plugins"));
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function saveFiles(){
        if(file_exists($this->getDataFolder()."config.yml")){
            if($this->getConfig()->get("version") !== $this->getDescription()->getVersion() or !$this->getConfig()->exists("version")){
		$this->getServer()->getLogger()->warning("An invalid configuration file for ".$this->getDescription()->getName()." was detected.");
		if($this->getConfig()->getNested("plugin.autoUpdate") === true){
		    $this->saveResource("config.yml", true);
                    $this->getServer()->getLogger()->warning("Successfully updated the configuration file for ".$this->getDescription()->getName()." to v".$this->getDescription()->getVersion().".");
		}
	    }	
        }
        else{
            $this->saveDefaultConfig();
        }
    }
    private function registerAll(){
    	$this->queryfacade = array();
    	$this->getServer()->getCommandMap()->register("queryfacade", new QueryFacadeCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new QueryFacadeListener($this), $this);
    }
    public function getCloakPlayerCount(){
	return $this->queryfacade["playerCount"];
    }
    public function setCloakPlayerCount($count = 0){
    	$this->queryfacade["playerCount"] = $count;
    }
    public function getCloakMaxPlayerCount(){
    	return $this->queryfacade["maxPlayerCount"];
    }
    public function setCloakMaxPlayerCount($count = 1){
    	$this->queryfacade["maxPlayerCount"] = $count;
    }
    public function getCloakPlayerList(){
    	return $this->queryfacade["playerList"];
    }
    public function setCloakPlayerList(array $players){
    	$this->queryfacade["playerList"] = $players;
    }
    public function getCloakLevel(){
    	return $this->queryfacade["level"];
    }
    public function setCloakLevel($level){
    	$this->queryfacade["level"] = $level;
    }
    public function getCloakPlugins(){
    	return $this->queryfacade["plugins"];
    }
    public function setCloakPlugins(array $plugins){
    	$this->queryfacade["plugins"] = $plugins;
    }
}
