<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer\Renderer;

/**
 * Interface for a class which renders a mail template.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface RendererInterface
{
    /**
     * Render the given params in to the named template.
     *
     * @param  string $template
     * @param  array  $params
     *
     * @return string
     */
    public function render($template, array $params = []);
}
