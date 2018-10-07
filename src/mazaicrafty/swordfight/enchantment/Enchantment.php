<?php

namespace mazaicrafty\swordfight\enchantment;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

class Enchantment{

    private $weapon;
    private $type;

    public function __construct(Item $weapon, int $type = -1){
        $this->weapon = $weapon;
        $this->type = $type;
    }

    public function enchant(): Item{
        $content = new EnchantmentInstance(Enchantment::getEnchantment($this->type));
        return $this->weapon->addEnchantment($content);
    }
}
