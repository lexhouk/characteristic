<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\characteristic\Controller\CharacteristicController;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Symfony\Component\Routing\Route;

/**
 * Provides routes for characteristic values.
 */
class CharacteristicValueRouteProvider extends AdminHtmlRouteProvider {

  /**
   * {@inheritdoc}
   */
  protected function getCollectionRoute(
    EntityTypeInterface $entity_type,
  ): ?Route {
    return parent::getCollectionRoute($entity_type)
      ?->setDefault(
        '_title_callback',
        CharacteristicController::class . '::title',
      )
      ?->setOption(
        'parameters',
        ['characteristic' => ['type' => 'entity:characteristic']],
      );
  }

}
