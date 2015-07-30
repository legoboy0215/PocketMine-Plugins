<?php

namespace queryfacade\event;

use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\event\Listener;
use queryfacade\QueryFacadeAPI;

class QueryFacadeListener implements Listener{
    public function __construct(QueryFacadeAPI $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onQueryRegenerate(QueryRegenerateEvent $event){
        $event->setPlugins($this->getPlugin()->getCloakPlugins());
        $event->setPlayerList($this->getPlugin()->getCloakPlayerList());
        $event->setPlayerCount($this->getPlugin()->getCloakPlayerCount());
        $event->setMaxPlayerCount($this->getPlugin()->getCloakMaxPlayerCount());
        $event->setWorld($this->getPlugin()->getCloakLevel());
    }
}
