<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer\Exception;

/**
 * This trait provides a factory method for exceptions which have static
 * methods to create themselves.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
trait ExceptionFactoryTrait
{
    /**
     * Create an instance of the exception with a formatted message.
     *
     * @param  string     $message  The exception message in sprintf format.
     * @param  array      $params   The sprintf parameters for the message.
     * @param  int        $code     Numeric exception code.
     * @param  \Exception $previous The previous exception.
     *
     * @return void
     */
    protected static function create(
        $message,
        array $params = [],
        $code = 0,
        $previous = null
    ) {
        array_unshift($params, $message);

        $message = call_user_func_array('sprintf', $params);

        return new self($message, $code, $previous);
    }

    /**
     * Returns a string representation of the type of a variable.
     *
     * @param  mixed $variable
     *
     * @return string
     */
    protected static function typeToString($variable)
    {
        return is_object($variable)
            ? get_class($variable)
            : gettype($variable);
    }
}
