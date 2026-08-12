<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests\Rule;

use Gklvns\Validator\Rule\NotEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class NotEmptyTest extends TestCase
{
    public function testMessage(): void
    {
        $notBlankRule = new NotEmpty(message: 'Test message.');

        $this->assertSame('Test message.', $notBlankRule->getMessage());
    }

    public function testValidator(): void
    {
        $notBlankRule = new NotEmpty();

        $this->assertSame(NotEmpty::class . 'Validator', $notBlankRule->getValidator());
    }

    public function testJsonSerialize(): void
    {
        $typeRule = new NotEmpty();

        $this->assertSame(['message' => 'This value must not be empty.'], $typeRule->jsonSerialize());
    }
}
