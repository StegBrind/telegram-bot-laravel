<?php

namespace App\Telegram\Commands\Tests;

use App\Telegram\Interfaces\ExtraCommandInfo;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command implements ExtraCommandInfo
{
    public $name = 'test';

    public $description = 'Just a test command';

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
        $this->replyWithMessage(['text' => 'Test completed.']);
    }
}
