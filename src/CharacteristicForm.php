<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base form for characteristic edit forms.
 */
class CharacteristicForm extends ContentEntityForm {

  /**
   * The entity label field parents.
   */
  protected const array PARENTS = ['name', 'widget', 0, 'value'];

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);

    NestedArray::setValue($form, [...static::PARENTS, '#id'], 'name');

    $key = ($type = $this->getEntity()->getEntityType())->getKey('id');

    $form[$key]['widget'][0]['value'] = [
      ...$form[$key]['widget'][0]['value'],
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#disabled' => !$this->entity->isNew(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#machine_name' => [
        'exists' => [$type->getClass(), 'load'],
        'source' => static::PARENTS,
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return parent::save($form, $form_state);
  }

}
