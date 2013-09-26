<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer;

use SclContact\ContactInterface;
use SclContact\EmailInterface as ContactEmail;
use SclZfMailer\Exception\InvalidArgumentException;
use Zend\Mail\Address\AddressInterface;

/**
 * A class to store and email and name pair.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Email implements AddressInterface
{
    /**
     * Instructs setContact() to use the persons name.
     */
    const PERSON_NAME = 'person';

    /**
     * Instructs setContact() to use the company name.
     */
    const COMPANY_NAME = 'company';

    /**
     * The name of the email address owner.
     *
     * @var string
     */
    private $name;

    /**
     * The email address.
     *
     * @var string
     */
    private $email;

    /**
     * Name and email can be set via constructor.
     *
     * @param  string $name
     * @param  string|ContactEmail $email
     */
    public function __construct($name = '', $email = '')
    {
        $this->setName($name);
        $this->setEmail($email);
    }

    /**
     * Create an instance of this class setting the values from the given
     * contact object.
     *
     * @param  ContactInterface $contact The contact to get the email address from.
     * @param  string           $useName Will accept constants PERSON_NAME & COMPANY_NAME
     *
     * @return Email
     */
    public static function fromContact(
        ContactInterface $contact,
        $nameFlag = self::PERSON_NAME
    ) {
        $instance = new self();

        $instance->setContact($contact, $nameFlag);

        return $instance;
    }

    /**
     * Set the name of the email address owner.
     *
     * @param  string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Return the name of the email address owner.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the email address.
     *
     * @param  string|ContactEmail $email
     *
     * @return                     void
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
    }

    /**
     * Return the email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email and name from the contact object.
     *
     * The name can either be set from the person name or the company name.
     *
     * @param  ContactInterface $contact The contact to get the email address from.
     * @param  string           $useName Will accept constants PERSON_NAME & COMPANY_NAME
     *
     * @return void
     */
    public function setContact(ContactInterface $contact, $useName = self::PERSON_NAME)
    {
        $allowedFlags = [self::PERSON_NAME, self::COMPANY_NAME];

        if (!in_array((string) $useName, $allowedFlags)) {
            throw InvalidArgumentException::unknownFlag(
                $useName,
                $allowedFlags
            );
        }

        if (self::PERSON_NAME === $useName) {
            $this->setName($contact->getName());
        } else {
            $this->setName($contact->getCompany());
        }

        $this->setEmail($contact->getEmail());
    }

    /**
     * String representation of address
     *
     * @return string
     */
    public function toString()
    {
        $string = '<' . $this->getEmail() . '>';
        $name   = $this->getName();
        if (null === $name) {
            return $string;
        }

        $string = $name . ' ' . $string;
        return $string;
    }
}
