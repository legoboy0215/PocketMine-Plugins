<?php

namespace easymessages\event;

use easymessages\EasyMessagesAPI;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;

class EasyMessagesListener implements Listener{
    public function __construct(EasyMessagesAPI $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onPlayerChat(PlayerChatEvent $event){
        if(!$this->getPlugin()->getConfig()->getNested("color.colorChat") !== true and !$event->getPlayer()->hasPermission("easymessages.action.color")){
            $event->setMessage($this->getPlugin()->replaceSymbols($event->getMessage(), true));
        }
    }
}
