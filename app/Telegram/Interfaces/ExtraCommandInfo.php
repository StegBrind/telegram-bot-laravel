<?php

namespace App\Telegram\Interfaces;

interface ExtraCommandInfo
{
    /**
     * @bool Determines if the command is hidden
     */
    public function isHidden(): bool;

    /**
     * @bool Determines if the command is phrase (which runs without a slash)
     */
    public function isPhrase(): bool;
}
