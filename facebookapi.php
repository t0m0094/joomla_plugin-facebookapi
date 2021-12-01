<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgSystemFacebookApi extends JPlugin
{
	function onBeforeCompileHead() {

		/*
		* Load the JDocument and the Language Object
		*/
		$obj_getdocument = JFactory::getDocument();
		$obj_getlanguage = JFactory::getLanguage();

		/*
		* Catch the language tag and transform it to the facebook format
		*/
		$current_language = str_replace("-","_",$obj_getlanguage->getTag());

		/*
		* Check if GDPR premission is required, if yes then check if it is given.
		*/
		$param_gdprStatus = $this->params->get('gdpr_status', 0);
		$param_gdprCookieName = $this->params->get('gdpr_cookie_name', "GDPRCookieName");
		$param_gdprCookieValue = $this->params->get('gdpr_cookie_value', "GDPRCookieValue");

		$script_url = 'https://connect.facebook.net/'.$current_language.'/sdk.js#xfbml=1&version=v12.0';

		if ($param_gdprStatus == 0 ) {
			/*
			* GDPR check if off, so add the script to the HEAD
			*/		
			$obj_getdocument->addScript($script_url);
		} else {
			if (isset($_COOKIE[$param_gdprCookieName]) && $_COOKIE[$param_gdprCookieName] == $param_gdprCookieValue) {
				/*
				* GDPR check is on and accepted, so add the script to the HEAD
				*/		
				$obj_getdocument->addScript($script_url);
			}
		}

		return true;
	}
}
?>