<?php

namespace Drupal\characteristic\Entity;

use Drupal\characteristic\CharacteristicValueAccessControlHandler;
use Drupal\characteristic\CharacteristicValueDeleteForm;
use Drupal\characteristic\CharacteristicValueForm;
use Drupal\characteristic\CharacteristicValueListBuilder;
use Drupal\characteristic\CharacteristicValueRouteProvider;
use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;

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
    'access' => CharacteristicValueAccessControlHandler::class,
    'list_builder' => CharacteristicValueListBuilder::class,
    'form' => [
      'default' => CharacteristicValueForm::class,
      'delete' => CharacteristicValueDeleteForm::class,
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
class CharacteristicValue extends Characteristic {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(
    EntityTypeInterface $entity_type,
  ): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['characteristic'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Characteristic'))
      ->setSetting('target_type', 'characteristic')
      ->setTranslatable(TRUE)
      ->setDefaultValueCallback(static::class . '::characteristic');

    return $fields;
  }

  /**
   * Default value callback for 'characteristic' base field.
   */
  public static function characteristic(): string {
    return \Drupal::routeMatch()->getRawParameter('characteristic');
  }

  /**
   * {@inheritdoc}
   */
  public function toUrl($rel = NULL, array $options = []): Url {
    return parent::toUrl($rel, $options)
      ->setRouteParameter('characteristic', $this->characteristic());
  }

}
