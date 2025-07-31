<?php

declare(strict_types=1);

namespace Drupal\characteristic;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;
use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base form for characteristic edit forms.
 */
class CharacteristicForm extends BundleEntityFormBase {

  /**
   * The characteristic storage.
   */
  private ConfigEntityStorageInterface $storage;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    $instance = parent::create($container);

    $instance->storage = $container->get('entity_type.manager')
      ->getStorage('characteristic');

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $characteristic = $this->entity;

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $characteristic->label(),
      '#maxlength' => 255,
      '#required' => TRUE,
    ];

    $form['cid'] = [
      '#type' => 'machine_name',
      '#default_value' => $characteristic->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#machine_name' => [
        'exists' => [$this, 'exists'],
        'source' => ['name'],
      ],
    ];

    return $this->protectBundleIdElement(parent::form($form, $form_state));
  }

  /**
   * Determines if the characteristic already exists.
   *
   * @param string $cid
   *   The characteristic ID.
   *
   * @return bool
   *   TRUE if the characteristic exists, FALSE otherwise.
   */
  public function exists(string $cid): bool {
    return $this->storage->load($cid) !== NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));

    return parent::save($form, $form_state);
  }

}
