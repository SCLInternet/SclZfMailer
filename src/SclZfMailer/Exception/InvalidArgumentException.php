<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer\Exception;

/**
 * InvalidArgumentException
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class InvalidArgumentException extends \InvalidArgumentException implements
    ExceptionInterface
{
    use ExceptionFactoryTrait;

    /**
     * @param  string $flag
     * @param  array  $allowedFlags
     *
     * @return InvalidArgumentException
     */
    public static function unknownFlag($flag, array $allowedFlags)
    {
        return self::create(
            'Unknown flag "%s"; allowed flags are [%s].',
            [$flag, implode(', ', $allowedFlags)]
        );
    }
}
