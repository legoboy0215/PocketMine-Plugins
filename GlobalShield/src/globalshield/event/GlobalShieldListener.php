<?php

namespace globalshield\event;

use globalshield\GlobalShieldAPI;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\event\player\PlayerBucketFillEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\Listener;

class GlobalShieldListener implements Listener{
    public function __construct(GlobalShieldAPI $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onBlockBreak(BlockBreakEvent $event){
        
    }
    public function onBlockPlace(BlockPlaceEvent $event){
        
    }
    public function onPlayerBucketEmpty(PlayerBucketEmptyEvent $event){
        
    }
    public function onPlayerBucketFill(PlayerBucketFillEvent $event){
        
    }
    public function onPlayerInteractEvent(PlayerInteractEvent $event){
        
    }
    public function onPlayerItemHeld(PlayerItemHeldEvent $event){
        
    }
}
