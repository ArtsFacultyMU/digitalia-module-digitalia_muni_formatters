<?php

namespace Drupal\digitalia_muni_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;

/**
 * Plugin implementation of the 'Taxonomy Term' formatter.
 *
 * @FieldFormatter(
 *  id = "digitalia_term_formatter",
 *  label = @Translation("Digitalia Taxonomy Formatter"),
 *  field_types = {
 *   "entity_reference"
 *  }
 * )
 */
class DigitaliaTermFormatter extends EntityReferenceFormatterBase
{
	/**
	 * {@inheritdoc}
	 */
	public static function defaultSettings()
	{
		return [
			'separator_option' => '|',
		] + parent::defaultSettings();
	}

	/**
	 * {@inheritdoc}
	 */
	public function settingsForm(array $form, FormStateInterface $form_state) {
		$element = [];
		$element['separator_option'] = [
			'#type' => 'textfield',
			'#title' => $this->t('Separator'),
			'#description' => $this->t('The separator.'),
			'#default_value' => $this->getSetting('separator_option'),
		];

		return $element;
	}

	/**
	 * {@inheritdoc}
	 */
	public function settingsSummary() {
		$summary = [];
		$summary[] = $this->t('The Terms will be displayed separated by "@separator"', ['@separator' => $this->getSetting('separator_option')]);
		return $summary;
	}

	/**
	 * {@inheritdoc}
	 */
	public function viewElements(FieldItemListInterface $items, $langcode) {
		// Don't output anything if there aren't any items.
		if (count($items) < 1) {
			return [];
		}

		$element = [];
		$separator = Html::escape($this->getSetting('separator_option'));

		$result = array();

		foreach ($this->getEntitiesToView($items, $langcode) as $entity) {
			array_push($result, Html::escape($entity->label()));
		}

		$element[0]['#markup'] = implode($separator, $result);
		return $element;
	}
}
