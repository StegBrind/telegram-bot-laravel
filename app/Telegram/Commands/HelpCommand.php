<?php

namespace App\Telegram\Commands;

use App\Telegram\Interfaces\ExtraCommandInfo;
use Telegram\Bot\Commands\Command;

class HelpCommand extends Command implements ExtraCommandInfo
{
    public $name = 'help';

    protected $aliases = ['listcommands'];

    public $description = 'Help command, Get a list of commands';

    public function isHidden(): bool
    {
        return false;
    }

    public function isPhrase(): bool
    {
        return false;
    }

    public function handle($arguments)
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $command)
        {
            if (!$command->isPhrase() && !$command->isHidden())
                $text .= sprintf('/%s - %s'.PHP_EOL, $command->name, $command->description);
        }

        $this->replyWithMessage(compact('text'));
    }
}
