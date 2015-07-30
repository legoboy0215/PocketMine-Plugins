<?php

namespace mytag\task;

use mytag\MyTagAPI;
use pocketmine\scheduler\PluginTask;
use pocketmine\Player;

class MessageBubbleTask extends PluginTask{
    public function __construct(MyTagAPI $plugin, Player $player, $message){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->getScheduler()->cancelTask($this->getTaskId());
    }
}
