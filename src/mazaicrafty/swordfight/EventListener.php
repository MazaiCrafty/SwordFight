<?php

namespace mazaicrafty\swordfight;

use pocketmine\event\Listener;

class EventListener implements Listener{

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    private function getPlugin(): Main{
        return $this->plugin;
    }
}
