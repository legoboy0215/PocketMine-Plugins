<?php

namespace easymessages\task;

use easymessages\EasyMessagesAPI;
use pocketmine\scheduler\PluginTask;

class UpdateMotdTask extends PluginTask{
    public function __construct(EasyMessagesAPI $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onRun($currentTick){
        $this->getPlugin()->setMotd(str_replace(
            array(
                "{SERVER_DEFAULT_LEVEL}",
                "{SERVER_MAX_PLAYER_COUNT}",
                "{SERVER_PLAYER_COUNT}",
                "{SERVER_NAME}",
                "{SERVER_PORT}",
                "{SERVER_TPS}"
            ),
            array(
                $this->getPlugin()->getServer()->getDefaultLevel()->getName(),
                $this->getPlugin()->getServer()->getMaxPlayers(),
                count($this->getPlugin()->getServer()->getOnlinePlayers()),
                $this->getPlugin()->getServer()->getServerName(),
                $this->getPlugin()->getServer()->getPort(),
                $this->getPlugin()->getServer()->getTicksPerSecond()
            ),
            $this->getPlugin()->getConfig()->getNested("motd.dynamicMotd")
        ));
    }
}
