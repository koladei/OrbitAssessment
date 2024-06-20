<?php

declare(strict_types=1);

namespace App\Enum;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

/**
 * A list of possible conditions for the item.
 *
 * @see https://schema.org/OfferItemCondition
 */
#[ApiResource(
    shortName: 'BookPublishingStatus',
    types: ['https://schema.org/BookPublishingStatus'],
    operations: [
        new GetCollection(provider: BookPublishingStatus::class . '::getCases'),
        new Get(provider: BookPublishingStatus::class . '::getCase'),
    ],
)]
enum BookPublishingStatus: string
{
    use EnumApiResourceTrait;

    /** Indicates that the item is new. */
    case None = 'https://schema.org/Publishing/None';

    /** Indicates that the item is refurbished. */
    case Basic = 'https://schema.org/Publishing/Basic';

    /** Indicates that the item is damaged. */
    case Pro = 'https://schema.org/Publishing/Pro';
}
