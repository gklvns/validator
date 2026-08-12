<?php

declare(strict_types=1);

namespace Gklvns\Validator\Rule;

use Gklvns\Validator\AbstractRuleValidator;

/**
 * @extends AbstractRuleValidator<Type>
 *
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
final class TypeValidator extends AbstractRuleValidator
{
    public function validate(mixed $value, mixed $rule): ?string
    {
        if (strtolower(gettype($value)) !== $rule->getType()) {
            return $rule->getMessage();
        }

        return null;
    }
}
