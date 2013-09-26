<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer\Renderer;

use SclZfMailer\Exception\RuntimeException;
use Zend\View\Renderer\PhpRenderer as ZendRenderer;
use Zend\View\Resolver\AggregateResolver;
use Zend\View\Resolver\TemplatePathStack;

/**
 * Renderer which renders PHP templates.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class PhpRenderer implements RendererInterface
{
    /**
     * The path to the template directory.
     *
     * @var string
     */
    private $templatePath;

    /**
     * @param  string $templatePath
     */
    public function __construct($templatePath)
    {
        $this->templatePath = (string) $templatePath;
    }

    /**
     * Renders a PHP template using Zend Framework Views.
     */
    public function render($template, array $params = [])
    {
        $renderer = new ZendRenderer();

        $resolver = new AggregateResolver();

        $stack = ['script_paths' => [$this->templatePath ]];

        $resolver->attach(new TemplatePathStack($stack));

        $renderer->setResolver($resolver);

        $renderer->setVars($params);

        try {
            return $renderer->render($template);
        } catch (\Zend\View\Exception\RuntimeException $e) {
            throw RuntimeException::renderFailed($template, $this->templatePath, $e);
        }
    }
}
