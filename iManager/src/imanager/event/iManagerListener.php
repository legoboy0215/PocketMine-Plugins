<?php

namespace imanager\event;

use imanager\iManager;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\Listener;

class iManagerListener implements Listener{
    public function __construct(iManager $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onPlayerPreLogin(PlayerPreLoginEvent $event){
        if(!$this->getPlugin()->isAddressWhitelisted($event->getPlayer()->getAddress()) and $this->getPlugin()->getConfig()->getNested("plugin.ipWhitelist") === true){
            $event->setCancelled(true);
        }
    }
}
