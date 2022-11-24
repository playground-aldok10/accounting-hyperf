<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class JwtSecretGenerateCommand extends HyperfCommand
{
    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     */
    protected ?string $name = 'jwt-secret:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Set the jwt secret key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $access_token_secret = $this->generateRandomKey(64);
        $refresh_token_secret = $this->generateRandomKey(128);

        if ($this->input->hasOption('show')) {
            $this->info("<comment>ACCESS_TOKEN_SECRET={$access_token_secret}</comment>");
            $this->info("<comment>REFRESH_TOKEN_SECRET={$refresh_token_secret}</comment>");
        }

        // Next, we will replace the application key in the environment file so it is
        // automatically setup for this developer. This key gets generated using a
        // secure random byte generator and is later base64 encoded for storage.
        if (! $this->setKeyInEnvironmentFile($access_token_secret, $refresh_token_secret)) {
            return;
        }

        $this->info('JWT Secret key set successfully.');
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
     * @param int $length
     *  
     * @return string
     */
    protected function generateRandomKey(int $length = 64)
    {
        return base64_encode(random_bytes($length));
    }

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $access_token_secret
     * @param  string  $refresh_token_secret
     * 
     * @return bool
     */
    protected function setKeyInEnvironmentFile($access_token_secret, $refresh_token_secret)
    {
        $accessTokenKey = (string) config('jwt.access_token_secret');
        $refreshTokenKey = (string) config('jwt.refresh_token_secret');

        if ((strlen($accessTokenKey) !== 0 || strlen($refreshTokenKey) !== 0) && (! $this->confirm("Are you sure to change the jwt secret key?"))) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($access_token_secret, $refresh_token_secret);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     * 
     * @param  string  $access_token_secret
     * @param  string  $refresh_token_secret
     * 
     * @return void
     */
    protected function writeNewEnvironmentFileWith($access_token_secret, $refresh_token_secret)
    {
        file_put_contents(BASE_PATH . '/.env', preg_replace(
            $this->accessTokenSecretReplacementPattern(),
            'ACCESS_TOKEN_SECRET='.$access_token_secret,
            file_get_contents(BASE_PATH . '/.env')
        ));

        file_put_contents(BASE_PATH . '/.env', preg_replace(
            $this->refreshTokenSecretReplacementPattern(),
            'REFRESH_TOKEN_SECRET='.$refresh_token_secret,
            file_get_contents(BASE_PATH . '/.env')
        ));
    }

    /**
     * Get a regex pattern that will match env ACCESS_TOKEN_SECRET with any random key.
     *
     * @return string
     */
    protected function accessTokenSecretReplacementPattern()
    {
        $escaped = preg_quote('='.config('jwt.access_token_secret'), '/');

        return "/^ACCESS_TOKEN_SECRET{$escaped}/m";
    }

    /**
     * Get a regex pattern that will match env REFRESH_TOKEN_SECRET with any random key.
     *
     * @return string
     */
    protected function refreshTokenSecretReplacementPattern()
    {
        $escaped = preg_quote('='.config('jwt.refresh_token_secret'), '/');

        return "/^REFRESH_TOKEN_SECRET{$escaped}/m";
    }
}