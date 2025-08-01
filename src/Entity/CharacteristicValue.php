<?php

namespace Drupal\characteristic\Entity;

use Drupal\characteristic\CharacteristicForm;
use Drupal\characteristic\CharacteristicValueListBuilder;
use Drupal\characteristic\CharacteristicValueRouteProvider;
use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the characteristic value entity.
 */
#[ContentEntityType(
  id: 'characteristic_value',
  label: new TranslatableMarkup('Characteristic value'),
  label_collection: new TranslatableMarkup('List characteristic values'),
  entity_keys: [
    'id' => 'cvid',
    'label' => 'name',
    'weight' => 'weight',
    'langcode' => 'langcode',
    'uid' => 'uid',
    'owner' => 'uid',
  ],
  handlers: [
    'list_builder' => CharacteristicValueListBuilder::class,
    'form' => [
      'default' => CharacteristicForm::class,
      'delete' => ContentEntityDeleteForm::class,
    ],
    'route_provider' => [
      'html' => CharacteristicValueRouteProvider::class,
    ],
  ],
  links: [
    'add-form' => '/admin/content/characteristic/{characteristic}/add',
    'collection' => '/admin/content/characteristic/{characteristic}',
    'delete-form' => '/admin/content/characteristic/{characteristic}/{characteristic_value}/delete',
    'edit-form' => '/admin/content/characteristic/{characteristic}/{characteristic_value}',
  ],
  admin_permission: 'administer characteristic value',
  collection_permission: 'access characteristic value overview',
  base_table: 'characteristic_value',
  data_table: 'characteristic_value_field_data',
  translatable: TRUE,
  common_reference_target: TRUE,
)]
class CharacteristicValue extends CharacteristicBase {}
