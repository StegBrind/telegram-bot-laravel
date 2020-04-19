<?php

namespace App\Telegram\Interfaces;

/**
 * Allows complete multi step commands
 *
 * Interface StepByStep
 * @package App\Telegram\Interfaces
 */
interface StepByStep
{
    public function mainStep(): void;

    public function reproduceStep(int $step, bool $goBack = false): void;
}
