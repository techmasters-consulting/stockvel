<?php

namespace Drupal\real_estate_agency\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Agency type entity.
 *
 * @ConfigEntityType(
 *   id = "real_estate_agency_type",
 *   label = @Translation("Agency type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\real_estate_agency\AgencyTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\real_estate_agency\Form\AgencyTypeForm",
 *       "edit" = "Drupal\real_estate_agency\Form\AgencyTypeForm",
 *       "delete" = "Drupal\real_estate_agency\Form\AgencyTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\real_estate_agency\AgencyTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "real_estate_agency_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "real_estate_agency",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/real_estate_agency_type/{real_estate_agency_type}",
 *     "add-form" = "/admin/structure/real_estate_agency_type/add",
 *     "edit-form" = "/admin/structure/real_estate_agency_type/{real_estate_agency_type}/edit",
 *     "delete-form" = "/admin/structure/real_estate_agency_type/{real_estate_agency_type}/delete",
 *     "collection" = "/admin/structure/real_estate_agency_type"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "type",
 *     "description",
 *     "help",
 *     "new_revision",
 *     "preview_mode",
 *     "display_submitted",
 *   }
 * )
 */
class AgencyType extends ConfigEntityBundleBase implements AgencyTypeInterface {

  /**
   * The Agency type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Agency type label.
   *
   * @var string
   */
  protected $label;

}
