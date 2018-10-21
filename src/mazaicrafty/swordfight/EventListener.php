<?php

namespace mazaicrafty\swordfight;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use mazaicrafty\swordfight\manage\SwordManager;

class EventListener implements Listener{

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    private function getPlugin(): Main{
        return $this->plugin;
    }

    public function onEntityDamage(EntityDamageEvent $event): void{
        $entity = $event->getEntity();
        if ($event instanceof EntityDamageByEntityEvent and $entity instanceof Player){
            $damager = $event->getDamager();
            if (!$damager instanceof Player){
                return;
            }
            
            if (SwordManager::existsPlayer($entity) && SwordManager::Player($damager)){
                if (SwordManager::isCoolTime($entity)){
                    $event->setCancelled(true);
                    return;
                }
            }
        }
    }
}
