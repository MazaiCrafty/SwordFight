<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\Player;
use pocketmine\scheduler\Task;

use mazaicrafty\swordfight\Main;
use mazaicrafty\swordfight\sound\Sound;
use mazaicrafty\swordfight\sound\SoundModule;

class CoolTimeTask extends Task{

    private $player;
    private $count;

    public function __construct(Player $player){
        $this->player = $player;
        $this->count = Main::getInstance()->getConfig()->get('cool-time');
        SwordManager::setCoolTime($player);
    }

    public function onRun(int $currentTick): void{
        if ($this->count < 0){
            $this->player->getLevel()->addSound(
                SoundModule::createSoundToPlayer(Sound::BLAZESHOOT, $this->player)
            );
            SwordManager::removePlayer($this->player);
        }
        
        $this->player->getLevel()->addSound(
            SoundModule::createSoundToPlayer(Sound::CLICK, $this->player)
        );
        $this->count--;
    }
}