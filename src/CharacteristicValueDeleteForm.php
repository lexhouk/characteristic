<?php

namespace Drupal\characteristic;

use Drupal\Core\Entity\ContentEntityDeleteForm;

/**
 * Provides a deletion confirmation form for characteristic value.
 */
class CharacteristicValueDeleteForm extends ContentEntityDeleteForm {

  use CharacteristicValueFormTrait;

}
