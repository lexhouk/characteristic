<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of characteristic value entities.
 *
 * @see \Drupal\characteristic\Entity\CharacteristicValue
 */
class CharacteristicValueListBuilder extends CharacteristicListBuilder {

  /**
   * The currently active route match object.
   */
  private readonly RouteMatchInterface $routeMatch;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(
    ContainerInterface $container,
    EntityTypeInterface $entity_type,
  ): static {
    $instance = parent::createInstance($container, $entity_type);

    $instance->routeMatch = $container->get('current_route_match');
    $instance->text = NULL;

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $headers = parent::buildHeader();

    $headers['label'] = $this->t('Name');

    return $headers;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityListQuery(): QueryInterface {
    return parent::getEntityListQuery()->condition(
      'characteristic',
      $this->routeMatch->getRawParameter('characteristic'),
    );
  }

}
