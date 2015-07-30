<?php

namespace easymessages\task;

use easymessages\EasyMessagesAPI;
use pocketmine\scheduler\PluginTask;

class AutoPopupTask extends PluginTask{
    public function __construct(EasyMessagesAPI $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        $this->getPlugin()->broadcastPopup($this->getPlugin()->drawRandomMessage($this->getPlugin()->getConfig()->getNested("popup.autoMessages")));
    }
}
