<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer;

use SclZfMailer\Renderer\RendererInterface;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Mailer
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Mailer
{
    /**
     * The renderer to use to resolve the template name.
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * The transport system to use.
     *
     * @var TransportInterface
     */
    private $transport;

    /**
     * Set the renderer to be used.
     *
     * @param  RendererInterface $renderer
     */
    public function __construct(
        TransportInterface $transport,
        RendererInterface  $renderer
    ) {
        $this->transport = $transport;
        $this->renderer  = $renderer;
    }

    /**
     * Get a message object ready to be sent.
     *
     * @param  Email  $from
     * @param  Email  $to
     * @param  string $subject
     * @param  string $templateName
     * @param  array  $templateParams
     *
     * @return Message
     */
    public function getMessage(
        Email $from,
        Email $to,
              $subject,
              $templateName,
        array $templateParams = []
    ) {
        $message = new Message();

        $message->setFrom($from);

        $message->setTo($to);

        $message->setSubject($subject);

        $message->setBody($this->renderer->render($templateName, $templateParams));

        return $message;
    }

    /**
     * Send a the email.
     *
     * @param  Email  $from
     * @param  Email  $to
     * @param  string $subject
     * @param  string $templateName
     * @param  array  $templateParams
     *
     * @return Message
     */
    public function send(
        Email $from,
        Email $to,
              $subject,
              $templateName,
        array $templateParams = []
    ) {
        $message = $this->getMessage(
            $from,
            $to,
            $subject,
            $templateName,
            $templateParams
        );

        $this->transport->send($message);
    }
}
