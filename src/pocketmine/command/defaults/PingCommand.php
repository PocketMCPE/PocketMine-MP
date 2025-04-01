<?php

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;

class PingCommand extends Command {

    public function __construct() {
        parent::__construct("ping", "Check your ping or another player's ping", "/ping [player]");
        // No permission requirement - command is free for everyone
    }

    /**
     * Executes the command when a player or console runs it.
     *
     * @param CommandSender $sender The sender of the command.
     * @param string $commandLabel The command alias used.
     * @param array $args The command arguments.
     * @return bool
     */
    public function execute(CommandSender $sender, $commandLabel, array $args){
        // Check if player is checking someone else's ping
        if (isset($args[0])) {
            $targetPlayer = Server::getInstance()->getPlayer($args[0]);

            if ($targetPlayer === null) {
                $sender->sendMessage("§cPlayer not found.");
                return false;
            }

            $targetName = $targetPlayer->getName();
            $ping = $targetPlayer->getPing();
            $sender->sendMessage("§a" . $targetName . "'s ping: §f" . $ping . " ms");
            return true;
        }

        // Check own ping
        if ($sender instanceof Player) {
            $ping = $sender->getPing();
            $sender->sendMessage("§aYour ping: §f" . $ping . " ms");
        } else {
            $sender->sendMessage("§cThis command can only be used in-game.");
        }

        return true;
    }
}