<?php

namespace skintools\event;

use pocketmine\event\Listener;
use skintools\SkinTools;

class SkinToolsListener implements Listener{
    public function __construct(SkinTools $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
}
