<?php

/**
 * FoundationFormPage
 * Displays a Form with various Fields to see its Foundation appearance
 *
 * @author Martijn van Nieuwenhoven <info@axyrmedia.nl>
 * @package foundation_forms
 */

class FoundationFormPage extends Page {

	public static $db = array(
	);

	public static $has_one = array(
	);

}
class FoundationFormPage_Controller extends Page_Controller {

	public static $allowed_actions = array (
		'FoundationForm'
	);
	
	function FoundationForm() {
		
		$fields = new FieldList(
			HeaderField::create('FormFieldsHeader', 'Form Fields', 2),
			// Usual suspects
			TextField::create('TextField', 'TextField'),
			EmailField::create('EmailField', 'EmailField'),
			PasswordField::create('PasswordField', 'PasswordField'),
			TextareaField::create('TextareaField', 'TextareaField'),
			FileField::create('FileField', 'FileField'),
			// Checkboxes, Radio buttons and Dropdown
			CheckboxField::create('CheckboxField', 'CheckboxField'),
			DropdownField::create('DropdownField', 'DropdownField')
				->setSource(array(
				'NZ' => 'New Zealand',
				'US' => 'United States',
				'GEM'=> 'Germany'
				))
				->setEmptyString(''),
			
			CheckboxsetField::create('CheckboxsetField', 'CheckboxsetField')
				->setSource(array(
					'NZ' => 'New Zealand',
					'US' => 'United States',
					'GEM'=> 'Germany'
				))
				,
			
			OptionsetField::create('OptionsetField', 'OptionsetField')
				->setSource(array(
					'NZ' => 'New Zealand',
					'US' => 'United States',
					'GEM'=> 'Germany'
				)),
			HeaderField::create('FieldGroupHeader', 'Field Groups', 3),
			// FieldGroups
			FieldGroup::create(
				TextField::create('FieldGroupTextField', 'TextField'),
				TextField::create('FieldGroupTextField1', 'TextField')
			),

			FieldGroup::create( 
				DropdownField::create('DropdownField2', 'DropdownField')
					->setSource(array(
						'NZ' => 'New Zealand',
						'US' => 'United States',
						'GEM'=> 'Germany'
					))
					->addExtraClass('large-6 small-6 columns')
					->setEmptyString(''),
				DropdownField::create('DropdownField3', 'DropdownField')
					->setSource(array(
						'NZ' => 'New Zealand',
						'US' => 'United States',
						'GEM'=> 'Germany'
					))
					->addExtraClass('large-6 small-6 columns')
					->setEmptyString('')
			),
			HeaderField::create('SwitchFieldsHeader', 'Switch Fields', 3),
			// FoundationSwitchFields 
			FoundationSwitchField::create('SwitchField', 'SwitchField', array(
				0	=> 'Off',
				1	=> 'On'
			))->addExtraClass('large-12'),
			FoundationSwitchField::create('SwitchField2', 'SwitchField', array(
				0	=> 'Off',
				1	=> 'On'
			))->addExtraClass('large round')
		);
		
		$actions = new FieldList(
			new FormAction('submitFoundationForm', 'Submit')
		);
		
		// set all to required to see the validation message appearance
		$required = array();
		if($dataFields = $fields->dataFields()) {
			foreach($dataFields as $child) {
				$required[] = $child->getName();
			}
		}
		
		$validator = new RequiredFields($required);
		
		$form = new FoundationForm($this, __FUNCTION__, $fields, $actions, $validator);
		
		// load submitted data, and clear them from session
		if($data = Session::get('FoundationForm' . $this->ID)) {
			$form->loadDataFrom($data);
			Session::clear('FoundationForm' . $this->ID);
		}
		return $form;
	}
	
	// submit the form and redirect back to the form
	function submitFoundationForm($data, $form) {
		if(isset($data['SecurityID'])) {
			unset($data['SecurityID']);
		}
		Session::set('FoundationForm' . $this->ID, $data);
		
		return $this->redirect($this->Link());
	}
}