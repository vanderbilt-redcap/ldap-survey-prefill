<?php
namespace Vanderbilt\LDAPSurveyPrefill;

require_once __DIR__ . '/../../plugins/Core/Libraries/LdapLookup.php';
require_once __DIR__ . '/../../plugins/Core/Libraries/Surveys.php';

use \Plugin\LdapLookup;
use \Plugin\Surveys;

class LDAPSurveyPrefill extends \ExternalModules\AbstractExternalModule{
	const LDAP_FIELD_DATA = 'ldap-field-data';
	const LDAP_SURVEY_PREFILL = 'ldap-survey-prefill';

	public function hook_every_page_before_render(){
		try{
			if(!Surveys::isSurveyURL() || isset($_GET['vunetid'])){
				return;
			}
	
			// We call isPublicSurveyURL() to make sure the login form is only displayed for the first survey in each project.
			if($_SERVER['REQUEST_METHOD'] === 'GET' && Surveys::isPublicSurveyURL() && !isset($_GET['__endpublicsurvey'])){
				$this->showLoginForm();
				return;
			}
	
			if(isset($_POST[static::LDAP_SURVEY_PREFILL])){
				self::handleLogin();
			}
		}
		catch(\Exception $e){
			$exceptionMessage = 'exception';
			$this->log($exceptionMessage, [
				'details' => $e->__toString()
			]);

			$minutes = 60;
			$maxOccurrences = 10;
			if($this->framework->throttle("message = ?", $exceptionMessage, 60*$minutes, 10)){
				throw new \Exception("More than $maxOccurrences exceptions have occurred in the last $minutes minutes.  Here is the latest exception:", 0, $e);
			}
		}
	}

	private function handleLogin(){
		$vunetid = @$_POST['vunetid'];
		$password = @$_POST['password'];

		if(!LdapLookup::authenticate($vunetid, $password)){
			$this->showLoginForm($vunetid, 'Login failed.  Please try again.');
			return;
		}

		$userDetails = LdapLookup::lookupUserDetailsByVunet($vunetid);

		$fieldMappings = [
			LdapLookup::VUNET_KEY => ['vunetid', 'vunet_id', 'vunet'],
			'givenname' => ['fname','first_name','firstname','ee_fname','recipient_first_name', 'name_first'],
			'sn' => ['lname','last_name','lastname','ee_lname','recipient_last_name', 'name_last', 'latsname'], // Yes, the misspelling is intentional
			'mail' => ['email','contact_email'],
			'telephonenumber' => ['phone','phonenum','phonenumber','phonenum1','phonebus','contact_phone'],
			'vanderbiltpersonemployeeid' => ['employee_id','empid','ee_id','recipient_employee_id'],
			
			LdapLookup::DEPT_NAME_KEY => ['dept'],
			LdapLookup::DEPT_NUMBER_KEY => ['deptid'],
			// '' => ['dob','birthdate','ee_dob'],
			// '' => ['title'],
			// '' => ['gender']
		];

        //Add user specified fields from config
        $vunetFields = array_filter($this->getProjectSetting('vunet_fields') ?? []);
        $firstFields = array_filter($this->getProjectSetting('first_name_fields') ?? []);
        $lastFields  = array_filter($this->getProjectSetting('last_name_fields') ?? []);
        $emailFields = array_filter($this->getProjectSetting('email_fields') ?? []);
        $phoneFields = array_filter($this->getProjectSetting('phone_fields') ?? []);
        $employeeFields = array_filter($this->getProjectSetting('employee_fields') ?? []);
        $fieldMappings[LdapLookup::VUNET_KEY]             = array_merge($fieldMappings[LdapLookup::VUNET_KEY], $vunetFields ? $vunetFields : []);
        $fieldMappings['givenname']       = array_merge($fieldMappings['givenname'], $firstFields ? $firstFields : []);
        $fieldMappings['sn']              = array_merge($fieldMappings['sn'], $lastFields ? $lastFields : []);
        $fieldMappings['mail']            = array_merge($fieldMappings['mail'], $emailFields ? $emailFields : []);
        $fieldMappings['telephonenumber'] = array_merge($fieldMappings['telephonenumber'], $phoneFields ? $phoneFields : []);
        $fieldMappings['vanderbiltpersonemployeeid'] = array_merge($fieldMappings['vanderbiltpersonemployeeid'],$employeeFields ? $employeeFields : []);

		$ldapFieldData = [];
		foreach($fieldMappings as $ldapField => $redcapFields){
			foreach($redcapFields as $redcapField){
				$ldapFieldData[$redcapField] = $userDetails[$ldapField][0];
			}
		}

		$ldapFieldData['name'] = $userDetails['givenname'][0] . ' ' . $userDetails['sn'][0];

		$_SESSION[self::LDAP_FIELD_DATA] = $ldapFieldData;
	}

	public function hook_survey_page(){
		?>
		<script>
			$(function(){
				var ldapFieldData = <?=json_encode($_SESSION[self::LDAP_FIELD_DATA])?>;
				var prefill_empty_only = <?=$this->getProjectSetting('prefill_empty_only') ? "true" : "false" ?>;
				var questionTable = $('#questiontable');
				for(var fieldName in ldapFieldData){
					var value = ldapFieldData[fieldName];
                    var oldVal = questionTable.find('input[name=' + fieldName + ']').val();
					if (oldVal === "" || !prefill_empty_only) {
                        questionTable.find('input[name=' + fieldName + ']').val(value);
                    }
				}
			})
		</script>
		<?php
	}

	private function showLoginForm($vunetid = '', $errorMessage = ''){
		require_once 'vandy-login-page/login.php';
		$this->exitAfterHook();
	}
}
