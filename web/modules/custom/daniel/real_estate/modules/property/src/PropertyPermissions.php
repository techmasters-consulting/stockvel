<?php

namespace Drupal\real_estate_property;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\real_estate_property\Entity\Property;

/**
 * Provides dynamic permissions for Property of different types.
 *
 * @ingroup real_estate_property
 */
class PropertyPermissions {

  use StringTranslationTrait;

  /**
   * Returns an array of node type permissions.
   *
   * @return array
   *   The Property by bundle permissions.
   *   @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function generatePermissions() {
    $perms = [];

    foreach (Property::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of node permissions for a given node type.
   *
   * @param \Drupal\real_estate_property\Entity\Property $type
   *   The Property type.
   *
   * @return array
   *   An associative array of permission names and descriptions.
   */
  protected function buildPermissions(Property $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "$type_id create entities" => [
        'title' => $this->t('Create new %type_name entities', $type_params),
      ],
      "$type_id edit own entities" => [
        'title' => $this->t('Edit own %type_name entities', $type_params),
      ],
      "$type_id edit any entities" => [
        'title' => $this->t('Edit any %type_name entities', $type_params),
      ],
      "$type_id delete own entities" => [
        'title' => $this->t('Delete own %type_name entities', $type_params),
      ],
      "$type_id delete any entities" => [
        'title' => $this->t('Delete any %type_name entities', $type_params),
      ],
    ];
  }

}
