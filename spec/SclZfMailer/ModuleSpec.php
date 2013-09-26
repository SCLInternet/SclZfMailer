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

class ModuleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf('SclZfMailer\Module');
    }

    public function it_provides_basic_autoloading_config()
    {
        $this->shouldImplement('Zend\ModuleManager\Feature\AutoloaderProviderInterface');

        $config = [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    'SclZfMailer' => realpath(__DIR__ . '/../../src/SclZfMailer')
                ]
            ]
        ];

        $this->getAutoloaderConfig()->shouldReturn($config);
    }

    public function it_provides_service_manager_config()
    {
        $this->shouldImplement('Zend\ModuleManager\Feature\ServiceProviderInterface');
    }

    public function it_provides_mailer_service()
    {
        $this->getServiceConfig()->shouldProvideService('scl_zf_mailer');
    }

    public function it_provides_transport_service()
    {
        $this->getServiceConfig()->shouldProvideService('scl_zf_mailer.transport');
    }

    public function it_provides_renderer_service()
    {
        $this->getServiceConfig()->shouldProvideService('scl_zf_mailer.renderer');
    }

    public function it_provides_config()
    {
        $this->shouldImplement('Zend\ModuleManager\Feature\ConfigProviderInterface');
    }

    public function it_returns_config_array()
    {
        $this->getConfig()->shouldHaveKey('scl_zf_mailer');
    }

    public function getMatchers()
    {
        return [
            /*
             * Matcher which checks for a given service key in a service
             * config array.
             *
             * Note: This checks for an exact match where as the ZF2 service
             * manager is much more relaxed.
             */
            'provideService' => function ($subject, $service) {
                $provides = false;

                $types = [
                    'invokables',
                    'factories',
                    'aliases',
                    'abstract_factories'
                ];

                foreach ($types as $type) {
                    if (isset($subject[$type]) && isset($subject[$type][$service])) {
                        $provides = true;
                        break;
                    }
                }

                return $provides;
            },
            'haveKey' => function ($subject, $key) {
                return array_key_exists($key, $subject);
            },
        ];
    }
}
