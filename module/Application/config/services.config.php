<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

use Zend\Session\Container;
use Zend\Session\SessionManager;

return array(
    'factories' => array(
        /**
         * ExtJS Direct Service
         */
        'Accountmanager\Direct\Service\login' => function($sm) {
            return new \Application\Direct\Action\LoginAction($sm);
        },
        'Accountmanager\Direct\Service\Resource' => function($sm) {
            return new \Application\Direct\Action\AuthProxyAction(
                $sm,
                new \Application\Direct\Action\ResourceAction($sm)
            );
        },
        'Accountmanager\Direct\Service\Category' => function($sm) {
            return new \Application\Direct\Action\AuthProxyAction(
                $sm,
                new \Application\Direct\Action\CategoryAction($sm)
            );
        },
        'Accountmanager\Direct\Service\Account' => function($sm) {
            return new \Application\Direct\Action\AuthProxyAction(
                $sm,
                new \Application\Direct\Action\AccountAction($sm)
            );
        },
        'Accountmanager\Direct\Service\User' => function($sm) {
            return new \Application\Direct\Action\AuthProxyAction(
                $sm,
                new \Application\Direct\Action\UserAction($sm)
            );
        },
        'Accountmanager\Direct\Service\Role' => function($sm) {
            return new \Application\Direct\Action\AuthProxyAction(
                $sm,
                new \Application\Direct\Action\RoleAction($sm)
            );
        },
        /**
         * Captcha
         */
        'Accountmanager\Service\Captcha' => function($sm) {
            $config = $sm->get('config');
            if(!isset($config['captcha'])) {
                throw new \Exception('captcha config not found in module');
            }
            return new \Application\Service\CaptchaService($config['captcha']);
        },
        /**
         * Auth\Crypt
         */
        'Accountmanager\Auth\Crypt' => function($sm) {
            $config = $sm->get('config');
            if(!isset($config['authCrypt'])) {
                throw new \Exception('auth crypt config not found in module');
            }
            return new \Application\Auth\Crypt($config['authCrypt']);
        },
        'Accountmanager\Auth\AuthenticationService' => function($sm) {
            return new \Zend\Authentication\AuthenticationService();
        },
        /**
         * Zend\Session\SessionManager
         */
        'Zend\Session\SessionManager' => function ($sm) {
            $config = $sm->get('config');
            if (isset($config['session'])) {
                $session = $config['session'];

                $sessionConfig = null;
                if (isset($session['config'])) {
                    $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                    $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                    $sessionConfig = new $class();
                    $sessionConfig->setOptions($options);
                }

                $sessionStorage = null;
                if (isset($session['storage'])) {
                    $class = $session['storage'];
                    $sessionStorage = new $class();
                }

                $sessionSaveHandler = null;
                if (isset($session['save_handler'])) {
                    // class should be fetched from service manager since it will require constructor arguments
                    $sessionSaveHandler = $sm->get($session['save_handler']);
                }

                $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

                if (isset($session['validators'])) {
                    $chain = $sessionManager->getValidatorChain();
                    foreach ($session['validators'] as $validator) {
                        $validator = new $validator();
                        $chain->attach('session.validate', array($validator, 'isValid'));

                    }
                }
            } else {
                $sessionManager = new SessionManager();
            }
            Container::setDefaultManager($sessionManager);
            return $sessionManager;
        },
        'Zend\Session\Handler\PropelHandler' => function($sm) {
            require_once 'Propel/Session/SaveHandler.php';
            return new \Propel\Session\SaveHandler();
        }
    )
);