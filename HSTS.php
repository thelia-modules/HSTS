<?php

namespace HSTS;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Model\Config as ConfigModel;
use Thelia\Model\ConfigQuery;
use Thelia\Module\BaseModule;

/**
 * @author Gilles Bourgeat >gilles.bourgeat@gmail.com>
 */
class HSTS extends BaseModule
{
    const CONFIG_KET_HSSTS_ENABLE = 'hsts_enable';
    const CONFIG_KET_HSSTS_MAX_AGE = 'hsts_max_age';
    const CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS = 'hsts_include_sub_domains';
    const CONFIG_KET_HSSTS_PRELOAD = 'hsts_preload';

    /** @var string */
    const DOMAIN_NAME = 'hsts';

    public function postActivation(ConnectionInterface $con = null)
    {
        if (null === ConfigQuery::create()->filterByName(self::CONFIG_KET_HSSTS_ENABLE)->findOne()) {
            (new ConfigModel())
                ->setName(self::CONFIG_KET_HSSTS_ENABLE)
                ->setValue(0)
                ->setHidden(0)
                ->setSecured(0)
                ->setLocale('fr_FR')
                ->setTitle('Activer HSTS https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security')
                ->setDescription('https://fr.wikipedia.org/wiki/HTTP_Strict_Transport_Security')
                ->setLocale('en_US')
                ->setTitle('Enable HSTS')
                ->setDescription('https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security')
                ->save($con);
        }

        if (null === ConfigQuery::create()->filterByName(self::CONFIG_KET_HSSTS_MAX_AGE)->findOne()) {
            (new ConfigModel())
                ->setName(self::CONFIG_KET_HSSTS_MAX_AGE)
                ->setValue(31536000)
                ->setHidden(0)
                ->setSecured(0)
                ->setLocale('fr_FR')
                ->setTitle('HSTS Max age')
                ->setDescription('https://fr.wikipedia.org/wiki/HTTP_Strict_Transport_Security')
                ->setLocale('en_US')
                ->setTitle('HSTS Max age')
                ->setDescription('https://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security')
                ->save($con);
        }

        if (null === ConfigQuery::create()->filterByName(self::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS)->findOne()) {
            (new ConfigModel())
                ->setName(self::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS)
                ->setValue(0)
                ->setHidden(0)
                ->setSecured(0)
                ->setLocale('fr_FR')
                ->setTitle('HSTS inclure les sous domains')
                ->setDescription('1 pour oui, 0 pour non')
                ->setLocale('en_US')
                ->setTitle('HSTS include sub domains')
                ->setDescription('1 for yes, 0 for no')
                ->save($con);
        }

        if (null === ConfigQuery::create()->filterByName(self::CONFIG_KET_HSSTS_PRELOAD)->findOne()) {
            (new ConfigModel())
                ->setName(self::CONFIG_KET_HSSTS_PRELOAD)
                ->setValue(0)
                ->setHidden(0)
                ->setSecured(0)
                ->setLocale('fr_FR')
                ->setTitle('HSTS preload')
                ->setDescription('1 pour oui, 0 pour non')
                ->setLocale('en_US')
                ->setTitle('HSTS preload')
                ->setDescription('1 for yes, 0 for no')
                ->save($con);
        }
    }
}
