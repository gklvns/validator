<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests\Rule;

use Gklvns\Validator\Rule\Length;
use PHPUnit\Framework\TestCase;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class LengthTest extends TestCase
{
    public function testValidator(): void
    {
        $lengthRule = new Length();

        $this->assertSame(Length::class . 'Validator', $lengthRule->getValidator());
    }

    public function testMessages(): void
    {
        $lengthRule = new Length(min: 1, max: 4);

        $this->assertSame('This value must be at least 1 characters.', $lengthRule->getMinMessage());
        $this->assertSame('This value must be at most 4 characters.', $lengthRule->getMaxMessage());
    }

    public function testJsonSerialize(): void
    {
        $lengthRule = new Length(min: 1, max: 4);

        $this->assertSame([
            'min' => 1,
            'minMessage' => 'This value must be at least %d characters.',
            'max' => 4,
            'maxMessage' => 'This value must be at most %d characters.',
        ], $lengthRule->jsonSerialize());
    }
}
