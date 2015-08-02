<?php

namespace easymessages\task;

use easymessages\EasyMessages;
use pocketmine\scheduler\PluginTask;

class AutoMessageTask extends PluginTask{
    public function __construct(EasyMessages $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        $this->getPlugin()->getServer()->broadcastMessage($this->getPlugin()->drawRandomMessage($this->getPlugin()->getConfig()->getNested("message.messages")));
    }
}
