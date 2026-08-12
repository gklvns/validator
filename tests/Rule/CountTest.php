<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests\Rule;

use Gklvns\Validator\Rule\Count;
use PHPUnit\Framework\TestCase;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class CountTest extends TestCase
{
    public function testValidator(): void
    {
        $countRule = new Count();

        $this->assertSame(Count::class . 'Validator', $countRule->getValidator());
    }

    public function testMessages(): void
    {
        $countRule = new Count(min: 1, max: 4);

        $this->assertSame('This value must have at least 1 items.', $countRule->getMinMessage());
        $this->assertSame('This value must have at most 4 items.', $countRule->getMaxMessage());
    }

    public function testJsonSerialize(): void
    {
        $countRule = new Count(min: 1, max: 4);

        $this->assertSame([
            'min' => 1,
            'minMessage' => 'This value must have at least %d items.',
            'max' => 4,
            'maxMessage' => 'This value must have at most %d items.',
        ], $countRule->jsonSerialize());
    }
}
