<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Events\URLWildcard;

use eZ\Publish\API\Repository\Values\Content\URLWildcard;
use eZ\Publish\SPI\Repository\Event\AfterEvent;

final class CreateEvent extends AfterEvent
{
    private $sourceUrl;

    private $destinationUrl;

    private $forward;

    /** @var \eZ\Publish\API\Repository\Values\Content\URLWildcard */
    private $urlWildcard;

    public function __construct(
        URLWildcard $urlWildcard,
        $sourceUrl,
        $destinationUrl,
        $forward
    ) {
        $this->sourceUrl = $sourceUrl;
        $this->destinationUrl = $destinationUrl;
        $this->forward = $forward;
        $this->urlWildcard = $urlWildcard;
    }

    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    public function getDestinationUrl()
    {
        return $this->destinationUrl;
    }

    public function getForward()
    {
        return $this->forward;
    }

    public function getUrlWildcard(): URLWildcard
    {
        return $this->urlWildcard;
    }
}
