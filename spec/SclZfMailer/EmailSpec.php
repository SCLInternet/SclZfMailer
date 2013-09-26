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
use SclZfMailer\Exception\InvalidArgumentException;

class EmailSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SclZfMailer\Email');
    }

    public function it_stores_name()
    {
        $name = 'Tom';

        $this->setName($name);

        $this->getName()->shouldReturn($name);
    }

    public function it_stores_email()
    {
        $email = 'tom@scl.co.uk';

        $this->setEmail($email);

        $this->getEmail()->shouldReturn($email);
    }

    public function it_takes_email_objects()
    {
        $email = 'tom@scl.co.uk';

        $this->setEmail(new \SclContact\Email($email));

        $this->getEmail()->shouldReturn($email);
    }

    public function it_can_be_set_by_contact()
    {
        $firstname  = 'Tom';
        $surname    = 'Oram';
        $email      = 'tom@scl.co.uk';

        $contact = new \SclContact\Contact();

        $contact->setName(new \SclContact\PersonName($firstname, $surname));
        $contact->setEmail(new \SclContact\Email($email));

        $this->setContact($contact);

        $this->getName()->shouldReturn($firstname . ' ' . $surname);
        $this->getEmail()->shouldReturn($email);
    }

    public function it_can_use_company_from_contact()
    {
        $company = 'SCL';
        $email   = 'info@scl.co.uk';

        $contact = new \SclContact\Contact();

        $contact->setCompany($company);
        $contact->setEmail(new \SclContact\Email($email));

        $this->setContact($contact, \SclZfMailer\Email::COMPANY_NAME);

        $this->getName()->shouldReturn($company);
        $this->getEmail()->shouldReturn($email);
    }

    public function it_throws_if_bad_name_flag_is_given()
    {
        $flag = 'bad_flag';

        $exception = new InvalidArgumentException(
            "Unknown flag \"$flag\"; allowed flags are [person, company]."
        );

        $this->shouldThrow($exception)->duringSetContact(
            new \SclContact\Contact(),
            $flag
        );
    }

    public function it_can_set_values_from_constructor()
    {
        $name  = 'Tom';
        $email = 'tom@scl.co.uk';

        $this->beConstructedWith($name, $email);

        $this->getName()->shouldReturn($name);
        $this->getEmail()->shouldReturn($email);
    }

    public function it_converts_to_string()
    {
        $this->setName('Tom');
        $this->setEmail('tom@scl.co.uk');

        $this->toString()->shouldReturn('Tom <tom@scl.co.uk>');
    }
}
