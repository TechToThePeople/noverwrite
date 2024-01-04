<?php

require_once 'noverwrite.civix.php';

function noverwrite_civicrm_buildForm($formName, &$form) {
  $names = ['CRM_Profile_Form_Edit','CRM_Event_Form_Registration_Register','CRM_Contribute_Form_Contribution_Main','CRM_Contact_Form_RelatedContact'];

  if (!in_array($formName, $names)) {
    return;
  }

  // Don't invoke if we're using CiviMobile, since CiviMobile depends on users being able
  // to edit records via profiles.
  $path = CRM_Utils_Array::value('HTTP_REFERER', $_SERVER);
  if($formName == 'CRM_Profile_Form_Edit' && preg_match('#civicrm/mobile#', $path)) {
    return;
  }
  $session = CRM_Core_Session::singleton();
  if (!$session->get('userID') && !array_key_exists("cs",$_GET)) {
    return; // anonymous user, nothing to bloc
  }

  // Profiles have their own way of identifyign the relevant contact.
  if ($formName == 'CRM_Profile_Form_Edit')  {
    if (!($form->get('id'))) {
      // If this is a profile, but the profile doesn't know its contactId
      return;
    }
  }
  // All other forms can use getContactId().
  else {
    // If admin user is using public form but contact_id has been set to 0
    if ($form->getContactID() == 0) {
     return;
   }
  }

  foreach (array( 'first_name', 'middle_name','last_name') as $f) {
    if (!$form->elementExists($f)) {
      continue;
    }
    $field=$form->getElement($f);
    if ($field && ($field->_attributes["value"] ?? FALSE))
      $form->freeze( $f );
  }
  // if you want to bloc it at the js level only, uncomment the next line and comment out the freeze
  // CRM_Core_Resources::singleton()->addScript(file_get_contents(dirname( __FILE__ ) ."/js/noverwrite.js"));
}

/**
 * Implementation of hook_civicrm_config
 */
function noverwrite_civicrm_config(&$config) {
  _noverwrite_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_install
 */
function noverwrite_civicrm_install() {
  return _noverwrite_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_enable
 */
function noverwrite_civicrm_enable() {
  return _noverwrite_civix_civicrm_enable();
}
