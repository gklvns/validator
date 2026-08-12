<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator\Rule;

use Gklvns\Validator\AbstractRuleValidator;
use Stringable;

/**
 * @extends AbstractRuleValidator<Length>
 *
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
class LengthValidator extends AbstractRuleValidator
{
    public function validate(mixed $value, mixed $rule): ?string
    {
        $value = match (true) {
            is_string($value),
            is_int($value),
            is_float($value), $value instanceof Stringable => mb_strlen((string) $value, 'UTF-8'),
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
