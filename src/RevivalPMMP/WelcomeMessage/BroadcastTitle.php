<?php

namespace RevivalPMMP\WelcomeMessage;


use pocketmine\Player;
use pocketmine\scheduler\Task;

class BroadcastTitle extends Task {

	private $player;
	private $msg;


	public function __construct(Player $player){
		$this->player = $player;
		$this->msg = WelcomeMessage::getInstance()->getMessage();
	}
	public function onRun(int $currentTick){
		$this->player->getServer()->broadcastTitle($this->msg[WelcomeMessage::TITLE],
			$this->msg[WelcomeMessage::SUBTITLE],
			$this->msg[WelcomeMessage::FADE_IN],
			$this->msg[WelcomeMessage::STAY],
			$this->msg[WelcomeMessage::FADE_OUT],
			[$this->player]
		);
	}
}