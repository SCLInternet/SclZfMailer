<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace spec\SclZfMailer\Renderer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhpRendererSpec extends ObjectBehavior
{
    private $templatePath;

    public function let()
    {
        $this->templatePath = realpath(__DIR__ . '/../../test-views');

        $this->beConstructedWith($this->templatePath);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('SclZfMailer\Renderer\PhpRenderer');
    }

    public function it_is_a_renderer()
    {
        $this->shouldImplement('SclZfMailer\Renderer\RendererInterface');
    }

    public function it_returns_string()
    {
        $this->render('test-template')->shouldBeString();
    }

    public function it_returns_template_contents()
    {
        $this->render('test-template')->shouldReturn("Hello world\n");
    }

    public function it_should_substitute_values()
    {
        $this->render('template-with-var', ['name' => 'Tom'])
             ->shouldReturn("Hello Tom");
    }

    public function it_should_throw_if_template_not_found()
    {
        $exception = new \SclZfMailer\Exception\RuntimeException(
            'Could not render template "missing-template" in "' . $this->templatePath . '".'
        );

        $this->shouldThrow($exception)->duringRender('missing-template');
    }
}
