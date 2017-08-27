<?php

namespace Dakzilla\Strongpass;

class Strongpass
{
    /** @var array */
    private static $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    /** @var array */
    private static $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    /** @var array */
    private static $symbols = ['{', '}', '[', ']', '(', ')', '/', '\\', '\'', '"', '`', '~', ',', ';', ':', '.', '<', '>'];

    /** @var string */
    protected $lastpass;

    /** @var int */
    protected $length;

    /** @var bool */
    protected $useLetters;

    /** @var bool */
    protected $useSymbols;

    /** @var bool */
    protected $useNumbers;

    /** @var array */
    private $characterSets;

    /**
     * Strongpass constructor.
     * @param array $config
     */
    public function __construct(
        array $config
    )
    {
        $this
            ->setLength($config['length'])
            ->setUseLetters($config['use_letters'])
            ->setUseNumbers($config['use_numbers'])
            ->setUseSymbols($config['use_symbols']);
    }

    /**
     * Generate a password according to the chosen configuration
     * @return string
     * @throws \Exception
     */
    public function generate()
    {
        $this->generateCharacterSet();

        if (!count($this->characterSets)) {
            throw new \Exception('No character set was selected. Please change your config file (strongpass.php) to use at least one of the following character sets for password generation: letters, numbers and/or symbols.');
        }

        $password = '';
        $i = 0;

        do {
            $randomCharacterSet = $this->getRandomCharacterSet();
            $randomCharacter = $this->getRandomCharacterFromSet($randomCharacterSet);
            $password .= $randomCharacter;
            $i++;
        } while ($i < $this->length);

        $this->setLastpass($password);

        return $password;
    }

    /**
     * @return string
     */
    public function getLastpass()
    {
        return $this->lastpass;
    }

    /**
     * Sets the length of the password
     * As a security concern, this package will not allow a length lower than 6
     * @param int $length
     * @return $this
     */
    public function setLength(int $length)
    {
        $this->length = max($length, 6);

        return $this;
    }

    /**
     * @param bool $useLetters
     * @return $this
     */
    public function setUseLetters(bool $useLetters)
    {
        $this->useLetters = $useLetters;

        return $this;
    }

    /**
     * @param bool $useNumbers
     * @return $this
     */
    public function setUseNumbers(bool $useNumbers)
    {
        $this->useNumbers = $useNumbers;

        return $this;
    }

    /**
     * @param bool $useSymbols
     * @return $this
     */
    public function setUseSymbols(bool $useSymbols)
    {
        $this->useSymbols = $useSymbols;

        return $this;
    }

    /**
     * @param string $lastpass
     * @return $this
     */
    public function setLastpass(string $lastpass)
    {
        $this->lastpass = $lastpass;

        return $this;
    }

    /**
     * Create the character set to use for generating the password
     */
    private function generateCharacterSet()
    {
        $characterSet = [];

        if ($this->useLetters) {
            $characterSet[] = static::$letters;
        }

        if ($this->useNumbers) {
            $characterSet[] = static::$numbers;
        }

        if ($this->useSymbols) {
            $characterSet[] = static::$symbols;
        }

        $this->characterSets = $characterSet;
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    private function getRand(int $min = PHP_INT_MIN, int $max = PHP_INT_MAX)
    {
        return random_int($min, $max);
    }

    /**
     * @return array
     */
    private function getRandomCharacterSet()
    {
        $randomInt = $this->getRand(0, count($this->characterSets) - 1);

        return $this->characterSets[$randomInt];
    }

    /**
     * @param array $characterSet
     * @return string|int
     */
    private function getRandomCharacterFromSet(array $characterSet)
    {
        $randomInt = $this->getRand(0, count($characterSet) - 1);

        return $characterSet[$randomInt];
    }

}