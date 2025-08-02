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
    return $this->characteristic(
      parent::getCollectionRoute($entity_type)?->setDefault(
        '_title_callback',
        CharacteristicController::class . '::title',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getAddFormRoute(EntityTypeInterface $entity_type): ?Route {
    return $this->characteristic(parent::getAddFormRoute($entity_type));
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditFormRoute(
    EntityTypeInterface $entity_type,
  ): ?Route {
    return $this->characteristic(parent::getEditFormRoute($entity_type));
  }

  /**
   * {@inheritdoc}
   */
  protected function getDeleteFormRoute(
    EntityTypeInterface $entity_type,
  ): ?Route {
    return $this->characteristic(parent::getDeleteFormRoute($entity_type));
  }

  /**
   * Describes a characteristic entity route parameter.
   *
   * @param \Symfony\Component\Routing\Route|null $route
   *   The generated route, if available.
   */
  private function characteristic(?Route $route): ?Route {
    return $route?->setOption(
      'parameters',
      ['characteristic' => ['type' => 'entity:characteristic']],
    );
  }

}
