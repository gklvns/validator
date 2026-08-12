<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Tests;

use Gklvns\Validator\AbstractRuleValidator;

/**
 * @extends AbstractRuleValidator<TestRule>
 *
 * @noinspection PhpUnused
 *
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
class TestRuleValidator extends AbstractRuleValidator
{
    public function validate(mixed $value, mixed $rule): ?string
    {
        if (!$rule->isValid()) {
            return $rule->getMessage();
        }

        return null;
    }
}
