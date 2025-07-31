<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Core\Config\Entity\DraggableListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines a class to build a listing of characteristic entities.
 *
 * @see \Drupal\characteristic\Entity\Characteristic
 */
class CharacteristicListBuilder extends DraggableListBuilder {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'characteristics';
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    return [
      'label' => $this->t('Characteristic name'),
      'id' => $this->t('Machine name'),
    ] + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    return [
      'label' => $entity->label(),
      'id' => ['#plain_text' => $entity->id()],
    ] + parent::buildRow($entity);
  }

}
