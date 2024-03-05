<?php

declare(strict_types=1);

namespace bonanoo;

use pocketmine\plugin\PluginBase;
use pocketmine\block\VanillaBlocks;
use pocketmine\network\mcpe\convert\TypeConverter;

class Main extends PluginBase{
    private $allBlocks = [];

    public function onLoad(): void{
        $this->allBlocks = VanillaBlocks::getAll();
        $blockStates = $this->generateBlockStates();
        $jsonContent = json_encode($blockStates, JSON_PRETTY_PRINT);

        $filePath = $this->getDataFolder() . "block_states.json";
        file_put_contents($filePath, $jsonContent);
      
    }
    public function onEnable(): void {}

    private function generateBlockStates(): array {
        $blockStates = [];

            
        foreach (VanillaBlocks::getAll() as $block) {
            $blockName = $block->getName(); 

            $blockTranslator = TypeConverter::getInstance()->getBlockTranslator();
            $id = $blockTranslator->internalIdToNetworkId($block->getStateId());
            $blockStates[$blockName] = $id;
        }
        return $blockStates;
    }
}
