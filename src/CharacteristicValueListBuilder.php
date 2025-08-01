<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of characteristic value entities.
 *
 * @see \Drupal\characteristic\Entity\CharacteristicValue
 */
class CharacteristicValueListBuilder extends CharacteristicListBuilder {

  /**
   * {@inheritdoc}
   */
  public static function createInstance(
    ContainerInterface $container,
    EntityTypeInterface $entity_type,
  ): static {
    $instance = parent::createInstance($container, $entity_type);

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

}
