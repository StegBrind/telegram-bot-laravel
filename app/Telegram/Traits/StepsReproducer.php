<?php

namespace App\Telegram\Traits;

/**
 * Helper for implementing multi step command
 *
 * Trait StepsReproducer
 * @package App\Telegram\Traits
 */

trait StepsReproducer
{
    protected array $steps;

    public function reproduceStep(int $step, bool $goBack = false): void
    {
        $message = $this->update->getMessage();
        try
        {
            $this->steps[$step]($message, $step, $goBack);
        }
        catch (\Exception $e)
        {
            $this->mainStep();
        }
    }

    public function setStep(int $step, array $extra_data = []): void
    {
        $this->telegramUser->current_action =
            array_merge($this->telegramUser->current_action, compact('step'), $extra_data);

        $this->telegramUser->save();
    }

    public function handle($arguments)
    {
        if (empty($this->telegramUser->current_action))
        {
            $this->mainStep();
        }
        else if ($this->update->getMessage()->getText() == 'Back to Main menu')
        {
            $this->telegramUser->current_action = '{}';
            $this->telegramUser->save();
            $this->triggerCommand('Main menu');
        }
        else
        {
            $this->reproduceStep($this->telegramUser->current_action['step']);
        }
    }
}
