<?php
/**
 * SclZfMailer (https://github.com/SCLInternet/SclZfMailer)
 *
 * @link https://github.com/SCLInternet/SclZfMailer for the canonical source repository
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace SclZfMailer;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * ZF2 Module class for the SclZfMailer module.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'scl_zf_mailer' => function ($serviceManager) {
                    return new \SclZfMailer\Mailer(
                        $serviceManager->get('scl_zf_mailer.transport'),
                        $serviceManager->get('scl_zf_mailer.renderer')
                    );
                },
                'scl_zf_mailer.transport' => function ($serviceManager) {
                    return new \Zend\Mail\Transport\Sendmail();
                },
                'scl_zf_mailer.renderer' => function ($serviceManager) {
                    return new \SclZfMailer\Renderer\PhpRenderer(
                        $serviceManager->get('Config')['scl_zf_mailer']['template_path']
                    );
                },
            ],
        ];
    }
}
