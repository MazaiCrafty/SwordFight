<?php

namespace mazaicrafty\swordfight\manage;

use pocketmine\Player;
use pocketmine\scheduler\Task;

use mazaicrafty\swordfight\Main;

class CoolTimeTask extends Task{

    private $player;
    private $count;

    public function __construct(Player $player){
        $this->player = $player;
        $this->count = Main::getInstance()->getConfig()->get('cool-time');
    }

    public function onRun(int $currentTick): void{
        if ($this->count < 0){
            // クールタイム終了時、サウンドをプレイヤーの座標に流す
            //
        }
        // count変数に代入された整数分の回数だけサウンドを流す
        $this->count--;
    }
}
