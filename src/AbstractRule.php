<?php

declare(strict_types=1);

/*
 * (c) Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gklvns\Validator;

use JsonSerializable;
use LogicException;

/**
 * @author Georgijs Kļaviņš <georgijs.klavins@gmail.com>
 */
abstract class AbstractRule implements JsonSerializable
{
    /**
     * @var class-string<AbstractRuleValidator<object>>|null
     */
    private ?string $validator = null;

    /**
     * @return class-string<AbstractRuleValidator<object>>
     */
    public function getValidator(): string
    {
        // @phpstan-ignore return.type
        return $this->validator ?? static::class . 'Validator';
    }

    public function setValidator(string $validator): self
    {
        if (!is_subclass_of($validator, AbstractRuleValidator::class)) {
            throw new LogicException(sprintf('Class "%s" must extend "%s".', $validator, AbstractRuleValidator::class));
        }

        $this->validator = $validator;

        return $this;
    }
}
