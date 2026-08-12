<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests\Rule;

use Gklvns\Validator\Rule\Type;
use PHPUnit\Framework\TestCase;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class TypeTest extends TestCase
{
    public function testType(): void
    {
        $typeRule = new Type('string');

        $this->assertSame('string', $typeRule->getType());
    }

    public function testMessage(): void
    {
        $typeRule = new Type('string');

        $this->assertSame('This value must of be of type "string".', $typeRule->getMessage());
    }

    public function testValidator(): void
    {
        $typeRule = new Type('string');

        $this->assertSame(Type::class . 'Validator', $typeRule->getValidator());
    }

    public function testJsonSerialize(): void
    {
        $typeRule = new Type('string');

        $this->assertSame(
            ['type' => 'string', 'message' => 'This value must of be of type "%s".'],
            $typeRule->jsonSerialize(),
        );
    }
}
