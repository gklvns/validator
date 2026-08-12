<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests;

use Gklvns\Validator\Violation;
use PHPUnit\Framework\TestCase;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
class ViolationTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $testRule = new TestRule();

        $violation = new Violation($testRule, '', $testRule->getMessage());

        $this->assertSame(
            [
                'rule' => ['message' => 'Test message.'],
                'value' => '',
                'errorMessage' => 'Test message.',
            ],
            $violation->jsonSerialize(),
        );
    }
}
