<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class SimpleCipherTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once 'SimpleCipher.php';
    }

    /**
     * Here we take advantage of the fact that plaintext of "aaa..." doesn't
     * output the key. This is a critical problem with shift ciphers, some
     * characters will always output the key verbatim.
     *
     * Uuid: b8bdfbe1-bea3-41bb-a999-b41403f2b15d
     */
    #[TestDox('Random key cipher -> Can encode')]
    public function testRandomKeyCipherCanEncode(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals(substr($cipher->key, 0, 10), $cipher->encode($plaintext));
    }

    /**
     * Uuid: 3dff7f36-75db-46b4-ab70-644b3f38b81c
     */
    #[TestDox('Random key cipher -> Can decode')]
    public function testRandomKeyCipherCanDecode(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'aaaaaaaaaa';
        $this->assertEquals($plaintext, $cipher->decode(substr($cipher->key, 0, 10)));
    }

    /**
     * Uuid: 8143c684-6df6-46ba-bd1f-dea8fcb5d265
     */
    #[TestDox('Random key cipher -> Is reversible')]
    public function testRandomKeyCipherIsReversible(): void
    {
        $cipher = new SimpleCipher();
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    /**
     * Uuid: defc0050-e87d-4840-85e4-51a1ab9dd6aa
     */
    #[TestDox('Random key cipher -> Key is made only of lowercase letters')]
    public function testRandomCipherKeyIsLowercaseLetters(): void
    {
        $cipher = new SimpleCipher();
        $this->assertMatchesRegularExpression('/\A[a-z]+\z/', $cipher->key);
    }

    /**
     * Uuid: 565e5158-5b3b-41dd-b99d-33b9f413c39f
     */
    #[TestDox('Substitution cipher -> Can encode')]
    public function testSubstitutionCipherCanEncode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    /**
     * Uuid: d44e4f6a-b8af-4e90-9d08-fd407e31e67b
     */
    #[TestDox('Substitution cipher -> Can decode')]
    public function testSubstitutionCipherCanDecode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'aaaaaaaaaa';
        $ciphertext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    /**
     * Uuid: 70a16473-7339-43df-902d-93408c69e9d1
     */
    #[TestDox('Substitution cipher -> Is reversible')]
    public function testSubstitutionCipherIsReversible(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'abcdefghij';
        $this->assertEquals($plaintext, $cipher->decode($cipher->encode($plaintext)));
    }

    /**
     * Uuid: 69a1458b-92a6-433a-a02d-7beac3ea91f9
     */
    #[TestDox('Substitution cipher -> Can double shift encode')]
    public function testSubstitutionCipherCanDoubleShiftEncode(): void
    {
        $cipher = new SimpleCipher('iamapandabear');
        $plaintext = 'iamapandabear';
        $ciphertext = 'qayaeaagaciai';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    /**
     * Uuid: 21d207c1-98de-40aa-994f-86197ae230fb
     */
    #[TestDox('Substitution cipher -> Can wrap on encode')]
    public function testSubstitutionCipherCanWrapEncode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'zzzzzzzzzz';
        $ciphertext = 'zabcdefghi';
        $this->assertEquals($ciphertext, $cipher->encode($plaintext));
    }

    /**
     * Uuid: a3d7a4d7-24a9-4de6-bdc4-a6614ced0cb3
     */
    #[TestDox('Substitution cipher -> Can wrap on decode')]
    public function testSubstitutionCipherCanWrapDecode(): void
    {
        $cipher = new SimpleCipher('abcdefghij');
        $plaintext = 'zzzzzzzzzz';
        $ciphertext = 'zabcdefghi';
        $this->assertEquals($plaintext, $cipher->decode($ciphertext));
    }

    /**
     * Uuid: e31c9b8c-8eb6-45c9-a4b5-8344a36b9641
     */
    #[TestDox('Substitution cipher -> Can encode messages longer than the key')]
    public function testSubstitutionCipherCanEncodeMessageLongerThanKey(): void
    {
        $cipher = new SimpleCipher('abc');
        $cipherText = 'iboaqcnecbfcr';
        $plainText = 'iamapandabear';
        $this->assertEquals($cipherText, $cipher->encode($plainText));
    }

    /**
     * Uuid: 93cfaae0-17da-4627-9a04-d6d1e1be52e3
     */
    #[TestDox('Substitution cipher -> Can decode messages longer than the key')]
    public function testSubstitutionCipherCanDecodeMessageLongerThanKey(): void
    {
        $cipher = new SimpleCipher('abc');
        $cipherText = 'iboaqcnecbfcr';
        $plainText = 'iamapandabear';
        $this->assertEquals($plainText, $cipher->decode($cipherText));
    }
}
