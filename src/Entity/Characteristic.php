<?php

namespace Drupal\characteristic\Entity;

use Drupal\characteristic\CharacteristicForm;
use Drupal\characteristic\CharacteristicListBuilder;
use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the characteristic entity.
 */
#[ContentEntityType(
  id: 'characteristic',
  label: new TranslatableMarkup('Characteristic'),
  label_collection: new TranslatableMarkup('List characteristics'),
  entity_keys: [
    'id' => 'cid',
    'label' => 'name',
    'weight' => 'weight',
    'langcode' => 'langcode',
    'uid' => 'uid',
    'owner' => 'uid',
  ],
  handlers: [
    'list_builder' => CharacteristicListBuilder::class,
    'form' => [
      'default' => CharacteristicForm::class,
      'delete' => ContentEntityDeleteForm::class,
    ],
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
  ],
  links: [
    'add-form' => '/admin/content/characteristic/add',
    'collection' => '/admin/content/characteristic',
    'delete-form' => '/admin/content/characteristic/{characteristic}/delete',
    'edit-form' => '/admin/content/characteristic/{characteristic}/edit',
  ],
  admin_permission: 'administer characteristic',
  collection_permission: 'access characteristic overview',
  base_table: 'characteristic',
  data_table: 'characteristic_field_data',
  translatable: TRUE,
  common_reference_target: TRUE,
)]
class Characteristic extends CharacteristicBase {}
