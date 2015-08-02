<?php

namespace signfilter;

use pocketmine\plugin\PluginBase;
use signfilter\event\SignFilterListener;

class SignFilter extends PluginBase{
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
    public function hasBadText($line){
	return $this->checkText($line);
    }
    public function checkText($line){
	foreach($this->getConfig()->get("badWords") as $word){
	    if(stristr(trim($line), $word)){
	    	return true;
	    }
	}
    }
}
