<?php

namespace Components\Hashing;

use Components\Contracts\Hashing\Hasher as HasherContract;
use Components\Hashing\AbstractHasher;
use RuntimeException;

class DefaultHasher extends AbstractHasher implements HasherContract
{    
    /**
     * The default cost factor.
     *
     * @var int
     */
    protected $rounds = 8;

    /** 
     * The salt hasher
     * 
     * @var string
     */
    
    protected $salt = '';

    /**
     * Create a new hasher instance.
     *
     * @param  array  $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        if ($options == []) {
            $options = config('hashing.default', []);
        }

        $this->rounds = $options['rounds'] ?? $this->rounds;
        $this->salt = $options['salt'] ?? $this->salt;
    }

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array  $options
     * @return string
     *
     * @throws \RuntimeException
     */
    public function make($value, array $options = [])
    {
        $hash = password_hash($value . $this->salt($options), PASSWORD_DEFAULT, [
            'cost' => $this->cost($options),
        ]);

        if ($hash === false) {
            throw new RuntimeException('Hashing not supported.');
        }

        return $hash;
    }

    /**
     * Get information about the given hashed value.
     *
     * @param string $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if ((string) $hashedValue === '') {
            return false;
        }

        return password_verify($value . $this->salt($options), $hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return password_needs_rehash($hashedValue, PASSWORD_DEFAULT, [
            'cost' => $this->cost($options),
        ]);
    }

    /**
     * Set the default password work factor.
     *
     * @param  int  $rounds
     * @return $this
     */
    public function setRounds(int $rounds)
    {
        $this->rounds = (int) $rounds;

        return $this;
    }

    /**
     * Set the default salt password.
     *
     * @param  string  $salt
     * @return $this
     */
    public function setSalt(string $salt)
    {
        $this->salt = (string) $salt;

        return $this;
    }

    /**
     * Extract the cost value from the options array.
     *
     * @param  array  $options
     * @return int
     */
    protected function cost(array $options = [])
    {
        return $options['rounds'] ?? $this->rounds;
    }

    /**
     * Extract the salt value from the options array.
     *
     * @param  array  $options
     * @return int
     */
    protected function salt(array $options = [])
    {
        return $options['salt'] ?? $this->salt;
    }
}
