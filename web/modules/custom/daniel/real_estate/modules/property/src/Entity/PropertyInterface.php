<?php

namespace Drupal\real_estate_property\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Property entities.
 *
 * @ingroup real_estate_property
 */
interface PropertyInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   *
   * @return string
   *   The Property type.
   */
  public function getType();

  /**
   * Gets the Property title.
   *
   * @return string
   *   Name of the Property.
   */
  public function getTitle();

  /**
   * Sets the Property title.
   *
   * @param string $title
   *   The Property title.
   *
   * @return \Drupal\real_estate_property\Entity\PropertyInterface
   *   The called Property entity.
   */
  public function setTitle($title);

  /**
   * Gets the Property creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Property.
   */
  public function getCreatedTime();

  /**
   * Sets the Property creation timestamp.
   *
   * @param int $timestamp
   *   The Property creation timestamp.
   *
   * @return \Drupal\real_estate_property\Entity\PropertyInterface
   *   The called Property entity.
   */
  public function setCreatedTime($timestamp);

}
