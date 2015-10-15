<?php

require_once 'membershipcustomisation.civix.php';

/**
 * Get the price fields & price field options configured.
 *
 * The contribution form configured to trigger the check-box for is_recur to be set
 * when it corresponds with these configuration items.
 *
 * @return array
 */
function membershipcustomisation_civicrm_get_configured_items() {
  $supportedContributionFormIDs = array(
    // Price field 34 (ie. civicrm_price_field.id).
    34 => array(
      // Price field option id 64 (ie civicrm_price_field_value.id).
      64 => array(
        'is_renew' => 1,
        'frequency_interval' => 1,
        'installments' => 9,
      ),
      // Price field option id 63 (ie civicrm_price_field_value.id).
      63  => array(
        'is_renew' => 0,
      ),
    ),
    // Price field 32 etc...
    32 => array(
      78 => array(
        'is_renew' => 1,
        'frequency_interval' => 1,
        'installments' => 9,
      ),
      77  => array(
        'is_renew' => 0,
      ),
    ),
    // did you remember to put a comma after every ')' & every value above?
  );
  return $supportedContributionFormIDs;
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function membershipcustomisation_civicrm_config(&$config) {
  _membershipcustomisation_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function membershipcustomisation_civicrm_xmlMenu(&$files) {
  _membershipcustomisation_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function membershipcustomisation_civicrm_install() {
  _membershipcustomisation_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function membershipcustomisation_civicrm_uninstall() {
  _membershipcustomisation_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function membershipcustomisation_civicrm_enable() {
  _membershipcustomisation_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function membershipcustomisation_civicrm_disable() {
  _membershipcustomisation_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function membershipcustomisation_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membershipcustomisation_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function membershipcustomisation_civicrm_managed(&$entities) {
  _membershipcustomisation_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membershipcustomisation_civicrm_caseTypes(&$caseTypes) {
  _membershipcustomisation_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membershipcustomisation_civicrm_angularModules(&$angularModules) {
_membershipcustomisation_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function membershipcustomisation_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membershipcustomisation_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Build Form hook.
 *
 * @param string $formName
 * @param CRM_Contribute_Form_Contribution_Main $form
 *
function membershipcustomisation_civicrm_buildForm($formName, &$form) {
  $supportedContributionFormIDs = membershipcustomisation_civicrm_get_configured_items();
  if ($formName == 'CRM_Contribute_Form_Contribution_Main' && in_array($form->_id, array_keys($supportedContributionFormIDs))) {
    $priceField = 'price_' . $supportedContributionFormIDs[$form->_id]['price_field_id'];
    $noRenewOptions = json_encode($supportedContributionFormIDs[$form->_id]['no_renew_price_options']);
    $renewOptions = json_encode($supportedContributionFormIDs[$form->_id]['renew_price_options']);

    CRM_Core_Resources::singleton()->addScript("
    cj('.is_recur-section').hide();
    cj('#{$priceField}').on('change', function () {
      var priceFieldOption = cj('#{$priceField}').val();
      if ((cj.inArray(priceFieldOption, {$noRenewOptions}) > -1) {
        cj('#is_recur').prop('checked', false);
        cj('#is_recur').val(0);
      }
      if ((cj.inArray(priceFieldOption, {$renewOptions}) > -1) {
        cj('#is_recur').prop('checked', true);
      }
      });
  ");
    $defaults['is_recur'] = 1;
    $defaults['frequency_interval'] = 1;
    $defaults['installments'] = 9;
    $form->setDefaults($defaults);
  }
}
*/

/**
 * Implements hook_civicrm_validateForm().
 *
 * We are overriding form values to set recur based on price field options.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_validateForm
 *
 * @param string $formName
 * @param $fields
 * @param $files
 * @param CRM_Contribute_Form_Contribution_Main $form
 * @param $errors
 */
function membershipcustomisation_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if ($formName == 'CRM_Contribute_Form_Contribution_Main') {
    foreach ($form->_submitValues as $key => $value) {
      if (substr($key, 0, 6) == 'price_' && in_array(substr($key, 6), membershipcustomisation_get_supported_price_fields())) {
        $data = &$form->controller->container();
        if (in_array($value, membershipcustomisation_get_renew_price_fields_values())) {
          $data['values']['Main']['auto_renew'] = 1;

        }
        elseif (in_array($value, membershipcustomisation_get_no_renew_price_fields_values())) {
          $data['values']['Main']['auto_renew'] = 0;
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * We are overriding form values to set recur based on price field options.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_preProcess
 *
 * @param string $formName
 * @param CRM_Contribute_Form_Contribution_Main $form
 */
function membershipcustomisation_civicrm_preProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_Contribution_Confirm') {
    foreach ($form->_params as $key => $value) {
      if (substr($key, 0, 6) == 'price_' && in_array(substr($key, 6), membershipcustomisation_get_supported_price_fields())) {
        if (in_array($value, membershipcustomisation_get_renew_price_fields_values())) {
          $form->_values['is_recur'] = 1;
          $detail = membershipcustomisation_get_price_fields_value_spec(substr($key, 6),$value);
          $form->_params['frequency_interval'] = $detail['frequency_interval'];
          $form->_params['installments'] = $detail['installments'];
        }
        elseif (in_array($value, membershipcustomisation_get_no_renew_price_fields_values())) {
          $form->_values['is_recur'] = 0;
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * We are overriding form values to set recur based on price field options.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_postProcess
 *
 * @param string $formName
 * @param CRM_Contribute_Form_Contribution_Main $form
 */
function membershipcustomisation_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_Contribution_Main') {
    foreach ($form->_submitValues as $key => $value) {
      if (substr($key, 0, 6) == 'price_' && in_array(substr($key, 6), membershipcustomisation_get_supported_price_fields())) {
        if (in_array($value, membershipcustomisation_get_renew_price_fields_values())) {
          $form->_values['is_recur'] = 1;
        }
        elseif (in_array($value, membershipcustomisation_get_no_renew_price_fields_values())) {
          $form->_values['is_recur'] = 0;
        }
      }
    }
  }
}

/**
 * Get configured price fields.
 *
 * @return array
 */
function membershipcustomisation_get_supported_price_fields() {
  return array_keys(membershipcustomisation_civicrm_get_configured_items());
}

/**
 * Get price price value ids with force-renew.
 *
 * @param int $priceFieldID
 * @param int $priceFieldValueID
 *
 * @return array
 */
function membershipcustomisation_get_price_fields_value_spec($priceFieldID, $priceFieldValueID) {
  $config = membershipcustomisation_civicrm_get_configured_items();
  return $config[$priceFieldID][$priceFieldValueID];
}
/**
 * Get price price value ids with force-renew.
 *
 * @return array
 */
function membershipcustomisation_get_renew_price_fields_values() {
  $supportedConfig = membershipcustomisation_civicrm_get_configured_items();
  $priceOptions = array();
  foreach ($supportedConfig as $priceField) {
    foreach ($priceField as $priceFieldValueID => $priceOption) {
      if ($priceOption['is_renew']) {
        $priceOptions[] = $priceFieldValueID;
      }
    }
  }
  return $priceOptions;
}

/**
 * Get price value ids with force-renew.
 *
 * (Just getting all since not sure the price-fields will stay tied to the
 * form in the config)
 *
 * @return array
 */
function membershipcustomisation_get_no_renew_price_fields_values() {
  $supportedConfig = membershipcustomisation_civicrm_get_configured_items();
  $priceOptions = array();
  foreach ($supportedConfig as $priceOptionID => $priceOption) {
    if (!$priceOption['is_renew']) {
      $priceOptions[] = $priceOptionID;
    }
  }
  return $priceOptions;
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function membershipcustomisation_civicrm_preProcess($formName, &$form) {

}

*/
