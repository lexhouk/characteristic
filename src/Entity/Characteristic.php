<?php

declare(strict_types=1);

namespace Drupal\characteristic\Entity;

use Drupal\characteristic\CharacteristicForm;
use Drupal\characteristic\CharacteristicListBuilder;
use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\Attribute\ConfigEntityType;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the characteristic entity.
 */
#[ConfigEntityType(
  id: 'characteristic',
  label: new TranslatableMarkup('Characteristic'),
  label_collection: new TranslatableMarkup('List characteristics'),
  config_prefix: 'characteristic',
  entity_keys: [
    'id' => 'cid',
    'label' => 'name',
    'weight' => 'weight',
  ],
  handlers: [
    'list_builder' => CharacteristicListBuilder::class,
    'form' => [
      'default' => CharacteristicForm::class,
    ],
    'route_provider' => [
      'html' => AdminHtmlRouteProvider::class,
    ],
  ],
  links: [
    'add-form' => '/admin/content/characteristic/add',
    'collection' => '/admin/content/characteristic',
  ],
  admin_permission: 'administer characteristic',
  collection_permission: 'access characteristic overview',
  bundle_of: 'characteristic',
  config_export: [
    'name',
    'cid',
    'weight',
  ],
)]
class Characteristic extends ConfigEntityBundleBase {

  /**
   * The characteristic ID.
   */
  protected string $cid;

  /**
   * Name of the characteristic.
   */
  protected string $name;

  /**
   * The weight of this characteristic.
   */
  protected int $weight = 0;

  /**
   * {@inheritdoc}
   */
  public function id(): ?string {
    return $this->cid ?? NULL;
  }

}
