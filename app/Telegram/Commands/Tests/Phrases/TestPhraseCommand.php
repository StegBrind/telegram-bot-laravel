<?php

namespace App\Telegram\Commands\Tests\Phrases;

use App\Telegram\Interfaces\ExtraCommandInfo;
use Telegram\Bot\Commands\Command;

class TestPhraseCommand extends Command implements ExtraCommandInfo
{
    public $name = 'Test phrase command';

    public function isHidden(): bool
    {
        return false;
    }

    public function isPhrase(): bool
    {
        return true;
    }

    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'Phrase command was successfully completed.']);
    }
}
