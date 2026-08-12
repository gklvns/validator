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
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * @param mixed          $value
     * @param AbstractRule[] $rules
     *
     * @return Violation[]
     */
    public function validate(mixed $value, array $rules): array;
}
