<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class KeyGenerateCommand extends HyperfCommand
{
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     */
    protected ?string $name = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Set the application key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->generateRandomKey();

        if ($this->input->hasOption('show')) {
            $this->info('<comment>'.$key.'</comment>');
        }

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($key)) {
            return;
        }

        $this->info('Application key set successfully.');
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['show', 's', InputOption::VALUE_OPTIONAL, 'Show new key generate'],
        ];
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(random_bytes(60));
    }

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key)
    {
        $currentKey = (string) config('app_key');

        if (strlen($currentKey) !== 0 && (! $this->confirm("Are you sure to change the app key?"))) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key)
    {
        file_put_contents(BASE_PATH . '/.env', preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents(BASE_PATH . '/.env')
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('='.config('app_key'), '/');

        return "/^APP_KEY{$escaped}/m";
    }
}