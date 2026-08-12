<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Rule;

use Countable;
use Gklvns\Validator\AbstractRuleValidator;

/**
 * @extends AbstractRuleValidator<Count>
 *
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
class CountValidator extends AbstractRuleValidator
{
    public function validate(mixed $value, mixed $rule): ?string
    {
        $value = match (true) {
            $value instanceof Countable => count($value),
            is_iterable($value) => iterator_count($value),
            default => null,
        };

        if ($value === null) {
            return null;
        }

        if ($rule->getMin() !== null && $value < $rule->getMin()) {
            return $rule->getMinMessage();
        }

        if ($rule->getMax() !== null && $value > $rule->getMax()) {
            return $rule->getMaxMessage();
        }

        return null;
    }
}
