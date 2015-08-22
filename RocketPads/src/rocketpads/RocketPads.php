<?php

namespace rocketpads;

use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use rocketpads\event\RocketPadsListener;

class RocketPads extends PluginBase{
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
    	$this->getServer()->getPluginManager()->registerEvents(new RocketPadsListener($this), $this);
    }
    public function isRocketPad(Block $block){
        return $this->checkBlock($block) === true;
    }
    public function checkBlock(Block $block){
        if(is_array($this->getConfig()->getNested("pad.blockId"))) return in_array($block->getId().":".$block->getDamage(), $this->getConfig()->getNested("pad.blockId"));
    }
    public function getBaseValue(){
        return $this->getConfig()->getNested("pad.baseValue");
    }
    public function getLaunchDistance(){
        return (int) $this->getConfig()->getNested("pad.launchDistance");
    }
    public function launchPlayer(Player $player){
        if($this->isRocketPad($player->getLevel()->getBlock($player->floor()->subtract(0, 1, 0)))){
            switch($player->getDirection()){
                case 0:
                    $player->knockBack($player, 0, $this->getLaunchDistance(), 0, $this->getBaseValue());
                    break;
                case 1:
                    $player->knockBack($player, 0, 0, $this->getLaunchDistance(), $this->getBaseValue());
                    break;
                case 2:
                    $player->knockBack($player, 0, -$this->getLaunchDistance(), 0, $this->getBaseValue());
                    break;
                case 3:
                    $player->knockBack($player, 0, 0, -$this->getLaunchDistance(), $this->getBaseValue());
                    break;
            }
        }
    }
}
