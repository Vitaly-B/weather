<?php

declare(strict_types=1);

namespace App\Shared\Lib\Assertion;

use App\Shared\Domain\Exceptions\InvalidArgumentException;

final class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param string $message
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
