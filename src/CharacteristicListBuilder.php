<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Core\Entity\DraggableListBuilderTrait;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of characteristic entities.
 *
 * @see \Drupal\characteristic\Entity\Characteristic
 */
class CharacteristicListBuilder extends EntityListBuilder implements FormInterface {

  use DraggableListBuilderTrait {
    buildHeader as draggableHeader;
    buildRow as draggableRow;
  }

  /**
   * {@inheritdoc}
   */
  protected const SORT_KEY = 'weight';

  /**
   * {@inheritdoc}
   */
  public static function createInstance(
    ContainerInterface $container,
    EntityTypeInterface $entity_type,
  ): static {
    $instance = parent::createInstance($container, $entity_type);

    $instance->formBuilder = $container->get('form_builder');
    $instance->weightKey = 'weight';

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'characteristics';
  }

  /**
   * {@inheritdoc}
   */
  protected function getWeight(EntityInterface $entity): int|float {
    return (float) $entity->weight->value;
  }

  /**
   * {@inheritdoc}
   */
  protected function setWeight(
    EntityInterface $entity,
    int|float $weight,
  ): EntityInterface {
    $entity->weight->value = $weight;

    return $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    return [
      'label' => $this->t('Characteristic name'),
      'id' => $this->t('Machine name'),
    ] + $this->draggableHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    return [
      'label' => $entity->label(),
      'id' => ['#plain_text' => $entity->id()],
    ] + $this->draggableRow($entity);
  }

}
