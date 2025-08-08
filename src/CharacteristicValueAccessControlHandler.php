<?php

namespace Drupal\characteristic;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the characteristic value entity type.
 *
 * @see \Drupal\characteristic\Entity\CharacteristicValue
 */
class CharacteristicValueAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(
    EntityInterface $entity,
    $operation,
    AccountInterface $account,
  ): AccessResultInterface {
    return $operation === 'view'
      ? AccessResult::neutral()
      : parent::checkAccess($entity, $operation, $account);
  }

}
