<?php

namespace Drupal\characteristic\Plugin\Field\FieldWidget;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsSelectWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'characteristic' widget.
 */
#[FieldWidget(
  id: 'characteristic',
  label: new TranslatableMarkup('Characteristics'),
  field_types: ['entity_reference'],
  multiple_values: TRUE,
)]
class CharacteristicWidget extends OptionsSelectWidget {

  /**
   * The identifier of the supported entity type.
   */
  private const string TYPE = 'characteristic_value';

  /**
   * The entity type manager.
   */
  private readonly EntityTypeManagerInterface $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
  ): static {
    $instance = parent::create(
      $container,
      $configuration,
      $plugin_id,
      $plugin_definition,
    );

    $instance->entityTypeManager = $container->get('entity_type.manager');

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state,
  ): array {
    $element = parent::formElement(
      $items,
      $delta,
      $element,
      $form,
      $form_state,
    );

    $storage = $this->entityTypeManager->getStorage(static::TYPE);

    if (isset($element['#options']['_none'])) {
      $empty = $element['#options']['_none'];

      unset($element['#options']['_none']);
    }

    foreach ($element['#options'] as $id => $title) {
      $key = ($field = $storage->load($id)->characteristic)->target_id;

      if (!isset($element[$key])) {
        $element[$key] = [
          '#type' => 'select',
          '#title' => $field->entity->label(),
          '#weight' => $field->entity->weight->value,
        ];

        if (isset($empty)) {
          $element[$key]['#options']['_none'] = $empty;
        }
      }

      $element[$key]['#options'][$id] = $title;

      if (in_array($id, $element['#default_value'])) {
        $element[$key]['#default_value'][] = $id;
      }
    }

    $element['#type'] = 'container';

    unset($element['#options'], $element['#default_value']);

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(
    array $values,
    array $form,
    FormStateInterface $form_state,
  ): array {
    return array_map(
      fn(string $id): array => ['target_id' => $id],
      array_filter(
        array_values(
          NestedArray::getValue(
            $form_state->getUserInput(),
            [...$form['#parents'], $this->fieldDefinition->getName()],
          ),
        ),
        fn(string $id): bool => $id !== '_none',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function validateElement(
    array $element,
    FormStateInterface $form_state,
  ): void {}

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(
    FieldDefinitionInterface $field_definition,
  ): bool {
    $type = $field_definition->getFieldStorageDefinition()
      ->getSetting('target_type');

    return $type === static::TYPE;
  }

}
