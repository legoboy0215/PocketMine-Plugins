<?php

namespace skintools\event;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use skintools\SkinTools;

class SkinToolsListener implements Listener{
    public function __construct(SkinTools $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onEntityDamage(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
            if($event->getDamager() instanceof Player and $event->getEntity() instanceof Player){
                if($this->getPlugin()->hasTouchMode($event->getDamager())){
                    $event->setCancelled(true);
                    $this->getPlugin()->setStolenSkin($event->getDamager(), $event->getEntity());
                    $event->getDamager()->sendMessage("§eYou got ".$event->getEntity()->getName()."'s skin.");
                }
            }
        }
    }
    public function onPlayerLogin(PlayerLoginEvent $event){
        $this->getPlugin()->storeSkinData($event->getPlayer());
        $this->getPlugin()->setTouchMode($event->getPlayer(), false);
    }
}
