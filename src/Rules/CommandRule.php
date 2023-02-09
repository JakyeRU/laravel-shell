<?php


namespace Jakyeru\LaravelShell\Rules;

use Illuminate\Contracts\Validation\Rule;

class CommandRule implements Rule
{
    /**
     *
     * The error message.
     *
     * @var string
     */
    private string $error_message = '';

    /**
     * The list of commands that are not allowed to be run.
     *
     * @var array
     */
    private array $interactiveCommands = [
        'php artisan tinker',
        'php artisan serve',
        'php artisan queue:work',
        'php artisan queue:listen',
        'php artisan schedule:work',
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (empty($value)) {
            $this->error_message = __('The command cannot be empty.');
            return false;
        }

        foreach ($this->interactiveCommands as $command) {
            if (str_contains($value, $command)) {
                $this->error_message = __('This command is not allowed to be run.');
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->error_message;
    }
}