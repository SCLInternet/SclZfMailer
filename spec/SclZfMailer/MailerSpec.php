<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace spec\SclZfMailer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SclZfMailer\Email;
use SclZfMailer\Renderer\RendererInterface;
use Zend\Mail\Transport\TransportInterface;

class MailerSpec extends ObjectBehavior
{
    public function let(
        TransportInterface $transport,
        RendererInterface  $renderer
    ) {
        $this->beConstructedWith($transport, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SclZfMailer\Mailer');
    }

    public function it_returns_a_message()
    {
        $this->getMessage(new Email(), new Email(), '', '')
             ->shouldReturnAnInstanceOf('Zend\Mail\Message');
    }

    public function it_sets_message_from_address()
    {
        $from = new Email('Bob', 'bob@hotmail.com');

        $message = $this->getMessage($from, new Email(), '', '');

        $fromAddresses = $message->getFrom();

        $address = $fromAddresses->get('bob@hotmail.com');

        $address->getName()->shouldReturn('Bob');
    }

    public function it_sets_message_to_address()
    {
        $to = new Email('Alice', 'alice@gmail.com');

        $message = $this->getMessage(new Email(), $to, '', '');

        $toAddresses = $message->getTo();

        $address = $toAddresses->get('alice@gmail.com');

        $address->getName()->shouldReturn('Alice');
    }

    public function it_sets_message_subject()
    {
        $subject = 'Message Subject';

        $message = $this->getMessage(new Email(), new Email(), $subject, '');

        $message->getSubject()->shouldReturn($subject);
    }

    public function it_renders_message(RendererInterface $renderer)
    {
        $templateName = 'the-template';
        $body       = 'This is the rendered message.';

        $renderer->render($templateName, [])->willReturn($body);

        $message = $this->getMessage(
            new Email(),
            new Email(),
            '',
            $templateName
        );

        $message->getBody()->shouldReturn($body);
    }

    public function it_passes_template_parameters(RendererInterface $renderer)
    {
        $parameters = ['name' => 'value'];

        $renderer->render('', $parameters)->shouldBeCalled();

        $message = $this->getMessage(
            new Email(),
            new Email(),
            '',
            '',
            $parameters
        );
    }
}
