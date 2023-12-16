<?php

namespace Drupal\real_estate_agency\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Agency entities.
 *
 * @ingroup real_estate_agency
 */
interface AgencyInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Agency name.
   *
   * @return string
   *   Name of the Agency.
   */
  public function getName();

  /**
   * Sets the Agency name.
   *
   * @param string $name
   *   The Agency name.
   *
   * @return \Drupal\real_estate_agency\Entity\AgencyInterface
   *   The called Agency entity.
   */
  public function setName($name);

  /**
   * Gets the Agency creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Agency.
   */
  public function getCreatedTime();

  /**
   * Sets the Agency creation timestamp.
   *
   * @param int $timestamp
   *   The Agency creation timestamp.
   *
   * @return \Drupal\real_estate_agency\Entity\AgencyInterface
   *   The called Agency entity.
   */
  public function setCreatedTime($timestamp);

}
