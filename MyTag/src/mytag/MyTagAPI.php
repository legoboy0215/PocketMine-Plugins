<?php

namespace mytag;

use mytag\command\MyTagCommand;
use mytag\event\MyTagListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;

class MyTagAPI extends PluginBase{
    public $nametags;
    public function onEnable(){
        $this->saveFiles();
        $this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function saveFiles(){
    	if(!is_dir($this->getDataFolder())){
    	    mkdir($this->getDataFolder());
    	}
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
        $this->nametags = new Config($this->getDataFolder()."nametags.yml", Config::YAML);
    }
    public function registerAll(){
    	
    }
    public function getSavedNameTag(Player $player){
        return $this->nametags->get(strtolower($player->getName()));
    }
    public function saveNameTag(Player $player){
        $this->nametags->set(strtolower($player->getName()), $player->getNameTag());
        $this->nametags->save();
    }
}
