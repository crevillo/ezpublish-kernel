<?php

/**
 * File containing the RoutingListener class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Bundle\EzPublishCoreBundle\EventListener;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\Routing\Generator;
use eZ\Publish\Core\MVC\Symfony\Routing\RootLocationIdCalculator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use eZ\Publish\Core\MVC\Symfony\Event\PostSiteAccessMatchEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * This siteaccess listener handles routing related runtime configuration.
 */
class RoutingListener implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $urlAliasRouter;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\Generator
     */
    private $urlAliasGenerator;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Routing\RootLocationIdCalculator
     */
    private $rootLocationIdCalculator;

    public function __construct(ConfigResolverInterface $configResolver, RouterInterface $urlAliasRouter, Generator $urlAliasGenerator, RootLocationIdCalculator $rootLocationIdCalculator)
    {
        $this->configResolver = $configResolver;
        $this->urlAliasRouter = $urlAliasRouter;
        $this->urlAliasGenerator = $urlAliasGenerator;
        $this->rootLocationIdCalculator = $rootLocationIdCalculator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MVCEvents::SITEACCESS => array('onSiteAccessMatch', 200),
        );
    }

    public function onSiteAccessMatch(PostSiteAccessMatchEvent $event)
    {
        $rootLocationId = $this->rootLocationIdCalculator->getRootLocationId();
        $this->urlAliasRouter->setRootLocationId($rootLocationId);
        $this->urlAliasGenerator->setRootLocationId($rootLocationId);
        $this->urlAliasGenerator->setExcludedUriPrefixes($this->configResolver->getParameter('content.tree_root.excluded_uri_prefixes'));
    }
}
