<?php

namespace Drupal\characteristic\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides title callback for entities.
 */
class CharacteristicController extends ControllerBase {

  /**
   * Gets characteristic values overview page title.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $characteristic
   *   The characteristic entity object.
   */
  public function title(
    ContentEntityInterface $characteristic,
  ): TranslatableMarkup {
    return $this->t('@characteristic (@characteristic_value)', [
      '@characteristic' => $characteristic->label(),
      '@characteristic_value' => $this->entityTypeManager()
        ->getDefinition('characteristic_value')->getCollectionLabel(),
    ]);
  }

}
