<?php

namespace HSTS\Listener;

use HSTS\HSTS;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Model\ConfigQuery;

/**
 * @author Gilles Bourgeat >gilles.bourgeat@gmail.com>
 */
class KernelResponseListener implements EventSubscriberInterface
{
    public function response(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $response = $event->getResponse();

        $configs = ConfigQuery::create()->filterByName([
            HSTS::CONFIG_KET_HSSTS_ENABLE,
            HSTS::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS,
            HSTS::CONFIG_KET_HSSTS_PRELOAD,
            HSTS::CONFIG_KET_HSSTS_MAX_AGE
        ], Criteria::IN)
            ->find();

        if ($configs->count() !== 4) {
            return;
        }

        $enable = false;
        $headers = [
            HSTS::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS => null,
            HSTS::CONFIG_KET_HSSTS_PRELOAD => null,
            HSTS::CONFIG_KET_HSSTS_MAX_AGE => null
        ];

        foreach ($configs as $config) {
            switch ($config->getName()) {
                case HSTS::CONFIG_KET_HSSTS_ENABLE:
                    $enable = (int) $config->getValue() ? true : false;
                    break;
                case HSTS::CONFIG_KET_HSSTS_MAX_AGE:
                    $headers[HSTS::CONFIG_KET_HSSTS_MAX_AGE] = (int) $config->getValue();
                    break;
                case HSTS::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS:
                    $headers[HSTS::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS] = (int) $config->getValue() ? true : false;
                    break;
                case HSTS::CONFIG_KET_HSSTS_PRELOAD:
                    $headers[HSTS::CONFIG_KET_HSSTS_PRELOAD] = (int) $config->getValue() ? true : false;
                    break;
            }
        }

        if (!$enable) {
            return;
        }

        $header = 'max-age=' . $headers[HSTS::CONFIG_KET_HSSTS_MAX_AGE] . ';';

        if ($headers[HSTS::CONFIG_KET_HSSTS_INCLUDE_SUB_DOMAINS]) {
            $header .= ' includeSubDomains;';
        }

        if ($headers[HSTS::CONFIG_KET_HSSTS_PRELOAD]) {
            $header .= ' preload';
        }

        $response->headers->add([
            'Strict-Transport-Security' => $header
        ]);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => [
                ['response', 15]
            ]
        ];
    }
}