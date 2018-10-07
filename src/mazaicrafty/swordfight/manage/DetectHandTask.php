<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\scheduler\Task;

use mazaicrafty\swordfight\Main;

class DetectHandTask extends Task{

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick): void{
        foreach ($this->getPlayers() as $player){
            foreach ($this->getWorlds() as $world){
                if ($player->getLevel()->getName() === $world){
                    continue;
                }
                //
            }
        }
    }

    public function getPlayers(): array{
        return $this->plugin->getServer()->getOnlinePlayers();
    }

    public function getWorlds(): array{
        return $this->plugin->getConfig()->get('world');
    }
}
