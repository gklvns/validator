<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator;

/**
 * @template T of object
 *
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
abstract class AbstractRuleValidator
{
    /**
     * @param mixed $value
     * @param T     $rule
     *
     * @return string|null
     */
    abstract public function validate(mixed $value, mixed $rule): ?string;
}
