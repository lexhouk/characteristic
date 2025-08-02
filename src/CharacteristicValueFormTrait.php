<?php

namespace Drupal\characteristic;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Basement for characteristic value forms.
 */
trait CharacteristicValueFormTrait {

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param \Drupal\Core\Entity\ContentEntityInterface|null $characteristic
   *   (optional) The characteristic entity object. Defaults to NULL.
   */
  public function buildForm(
    array $form,
    FormStateInterface $form_state,
    ?ContentEntityInterface $characteristic = NULL,
  ): array {
    return parent::buildForm($form, $form_state);
  }

}
