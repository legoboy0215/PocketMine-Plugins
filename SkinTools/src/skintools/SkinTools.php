<?php

namespace skintools;

use pocketmine\plugin\PluginBase;
use skintools\event\SkinToolsListener;

class SkinTools extends PluginBase{
    public function onEnable(){
	$this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function registerAll(){
    	$this->getServer()->getPluginManager()->registerEvents(new SkinToolsListener($this), $this);
    }
}
