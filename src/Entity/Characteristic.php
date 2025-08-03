<?php

declare(strict_types=1);

namespace Drupal\characteristic\Entity;

use Drupal\characteristic\CharacteristicForm;
use Drupal\characteristic\CharacteristicListBuilder;
use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\EntityOwnerTrait;

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
class Characteristic extends ContentEntityBase implements ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(
    EntityTypeInterface $entity_type,
  ): array {
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields[$entity_type->getKey('id')] = BaseFieldDefinition::create('string')
      ->setLabel(t('ID'))
      ->setReadOnly(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ]);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ]);

    $fields['uid']
      ->setLabel(t('Authored by'))
      ->setDescription(t('The username of the characteristic author.'))
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 2,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ],
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The date and time that the characteristic was created.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 3,
      ]);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the characteristic was last edited.'))
      ->setTranslatable(TRUE);

    $fields['weight'] = BaseFieldDefinition::create('float')
      ->setLabel(new TranslatableMarkup('Weight'))
      ->setDefaultValue(0.0);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function preDelete(
    EntityStorageInterface $storage,
    array $entities,
  ): void {
    $ids = \Drupal::entityQuery($type = 'characteristic_value')
      ->accessCheck(FALSE)
      ->condition(
        'characteristic',
        array_map(
          fn(ContentEntityInterface $characteristic): string
            => $characteristic->id(),
          $entities,
        ),
        'IN',
      )
      ->execute();

    if (!empty($ids)) {
      $storage = \Drupal::entityTypeManager()->getStorage($type);

      foreach ($ids as $id) {
        $storage->delete([$storage->load($id)]);
      }
    }
  }

}
