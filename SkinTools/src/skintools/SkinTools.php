<?php

namespace skintools;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use skintools\command\SkinToolsCommand;
use skintools\event\SkinToolsListener;

class SkinTools extends PluginBase{
    public $skintools;
    public function onEnable(){
	$this->registerAll();
        $this->getServer()->getLogger()->info("§aEnabling ".$this->getDescription()->getFullName()."...");
    }
    public function onDisable(){
        $this->getServer()->getLogger()->info("§cDisabling ".$this->getDescription()->getFullName()."...");
    }
    private function registerAll(){
    	$this->skintools = array();
    	$this->getServer()->getCommandMap()->register("skintools", new SkinToolsCommand($this));
    	$this->getServer()->getPluginManager()->registerEvents(new SkinToolsListener($this), $this);
    }
    public function setStolenSkin(Player $player1, Player $player2){
    	$player1->setSkin($player2->getSkinData());
    }
    public function setTouchMode(Player $player, $touchMode = true){
    	if(is_bool($touchMode)) $this->skintools["touchMode"][strtolower($player->getName())] = $touchMode;
    }
    public function hasTouchMode(Player $player){
    	return $this->skintools["touchMode"][strtolower($player->getName())] === true;
    }
    public function storeSkinData(Player $player){
        $this->skintools["skinData"][strtolower($player->getName())] = $player->getSkinData();
    }
    public function getSkinData(Player $player){
        return $this->skintools["skinData"][strtolower($player->getName())];
    }
}
