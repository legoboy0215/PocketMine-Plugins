<?php

namespace signfilter\event;

use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Listener;
use signfilter\SignFilter;

class SignFilterListener implements Listener{
    public function __construct(SignFilter $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onSignChange(SignChangeEvent $event){
        if($this->getPlugin()->hasBadText($event->getBlock()->getLevel()->getTile($event->getBlock()))){
            $event->setCancelled(true);
        }
    }
}
