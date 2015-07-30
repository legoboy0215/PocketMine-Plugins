<?php

namespace blockfreezer;

use pocketmine\block\Block;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class BlockFreezer extends PluginBase implements Listener{
    public function onEnable(){
        $this->saveFiles();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
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
    private function isBlockSpecified(Block $block){
    	if(is_array($this->getConfig()->getNested("level.".strtolower($block->getLevel()->getName())))){
	    return in_array($block->getId().":".$block->getDamage(), $this->getConfig()->getNested("level.".strtolower($block->getLevel()->getName())));	
    	}
    	else{
    	    return null;
    	}
    }
    public function onBlockUpdate(BlockUpdateEvent $event){
	if($this->isBlockSpecified($event->getBlock())){
	    $event->setCancelled(true);
	}
    }
}
