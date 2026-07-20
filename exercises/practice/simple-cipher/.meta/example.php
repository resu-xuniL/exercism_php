<?php

class SimpleCipher
{
    public const LETTERS = "abcdefghijklmnopqrstuvwxyz";
    public string $key;

    public function __construct(string $key = null)
    {
        $key ??= $this->generateRandomKey();
        $this->keyIsValid($key);
        $this->key = $key;
    }

    public function encode(string $plainText): string
    {
        $shiftedLetters = '';

        for ($i = 0; $i < strlen($plainText); $i++) {
            $plainTextIndex = strpos(self::LETTERS, $plainText[$i]);
            $keyCharacter   = $this->key[$i % strlen($this->key)];
            $keyIndex       = strpos(self::LETTERS, $keyCharacter);
            $combinedIndex  = $plainTextIndex + $keyIndex;

            if ($combinedIndex >= strlen(self::LETTERS)) {
                $combinedIndex -= strlen(self::LETTERS);
            }

            $shiftedLetters .= self::LETTERS[$combinedIndex];
        }

        return $shiftedLetters;
    }

    public function decode(string $cipherText): string
    {
        $decryptedLetters = '';

        for ($i = 0; $i < strlen($cipherText); $i++) {
            $cipherTextIndex = strpos(self::LETTERS, $cipherText[$i]);
            $keyCharacter    = $this->key[$i % strlen($this->key)];
            $keyIndex        = strpos(self::LETTERS, $keyCharacter);
            $combinedIndex   = $cipherTextIndex - $keyIndex;

            if ($combinedIndex < 0) {
                $combinedIndex += strlen(self::LETTERS);
            }

            $decryptedLetters .= self::LETTERS[$combinedIndex];
        }

        return $decryptedLetters;
    }

    private function keyIsValid(string $key)
    {
        if (preg_match('/[A-Z]/', $key)) {
            throw new InvalidArgumentException('The key should not contain capital letters.');
        }

        if (preg_match('/[0-9]/', $key)) {
            throw new InvalidArgumentException('The key should not contain numbers.');
        }

        if (empty($key) && !is_null($key)) {
            throw new InvalidArgumentException('The key should not be an empty string.');
        }
    }

    private function generateRandomKey(): string
    {
        $cipherLetters = [];
        $letterCount   = strlen(self::LETTERS) - 1;

        for ($i = 0; $i < $letterCount; ++$i) {
            $cipherLetters[] = self::LETTERS[random_int(0, $letterCount)];
        }

        return implode('', $cipherLetters);
    }
}
