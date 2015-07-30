<?php

namespace signfilter;

use pocketmine\plugin\PluginBase;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use signfilter\event\SignFilterListener;

class SignFilterAPI extends PluginBase{
    public function onEnable(){
        $this->saveFiles();
	$this->registerAll();
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
    	$this->getServer()->getPluginManager()->registerEvents(new SignFilterListener($this), $this);
    }
    public function hasBadText(Tile $tile){
    	if($tile instanceof Sign){
    	    return $this->checkText($tile) === true;
    	}
    	else{
    	    return null;
    	}
    }
    public function checkText(Tile $tile){
    	if($tile instanceof Sign){
    	    foreach($tile->getText() as $text){
    	    	foreach($this->getConfig()->get("badWords") as $word){
    	    	    if(stristr($text, $word)){
    	    	    	return true;
    	    	    }
    	    	    else{
    	    	    	return false;
    	    	    }
    	    	}
    	    }
    	}
    }
}
