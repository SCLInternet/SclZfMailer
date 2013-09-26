<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer\Exception;

/**
 * RuntimeException
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
    use ExceptionFactoryTrait;

    /**
     * renderFailed
     *
     * @param  string     $template The template name.
     * @param  string     $path     The path to where the templates are stored.
     * @param  \Exception $previous Previous exception.
     *
     * @return RuntimeException
     */
    public static function renderFailed($template, $path, $previous = null)
    {
        return self::create(
            'Could not render template "%s" in "%s".',
            [$template, $path],
            0,
            $previous
        );
    }
}
