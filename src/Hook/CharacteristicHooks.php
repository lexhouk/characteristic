<?php

namespace Drupal\characteristic\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Hook implementations for characteristic.
 */
final class CharacteristicHooks {

  /**
   * Implements hook_help().
   */
  #[Hook('help')]
  public function help(
    string $route_name,
    RouteMatchInterface $route_match,
  ): string {
    if ($route_name !== 'help.page.characteristic') {
      return '';
    }

    return '<h3>' . t('About') . '</h3>' .
      '<p>' . t('This module introduces a custom administrative interface for managing product characteristics and their associated values. It defines two custom entities: "Characteristic" and "Characteristic value". Characteristics can be created, edited, deleted, and sorted. Each characteristic can have multiple values, which can also be managed through a dedicated interface.') . '</p>' .
      '<p>' . t('The module includes a custom FieldWidget for entity_reference fields that displays all characteristic values grouped by their parent characteristics using HTML select elements. This widget can be added to any content type, such as "Basic page", allowing site editors to select characteristic values in a user-friendly, grouped format.') . '</p>' .
      '<h3>' . t('Features') . '</h3>' .
      '<ul>' .
      '<li>' . t('Admin-only access to the management interface.') .'</li>' .
      '<li>' . t('Automatic deletion of characteristic values when a characteristic is deleted.') .'</li>' .
      '<li>' . t('Automatic assignment of the parent characteristic during value creation/editing.') .'</li>' .
      '<li>' . t('Machine names are auto-generated with transliteration and can be edited manually.') .'</li>' .
      '<li>' . t('Custom FieldWidget displays all values grouped by characteristic with no additional configuration required.') .'</li>' .
      '</ul>';
  }

}
