<?php

namespace Drupal\digitalia_muni_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Plugin\Field\FieldFormatter\StringFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;

/**
 * Plugin implementation of the 'Taxonomy Term' formatter.
 *
 * @FieldFormatter(
 *  id = "digitalia_text_formatter",
 *  label = @Translation("Digitalia Text"),
 *  field_types = {
 *   "string",
 *   "string_long",
 *   "text",
 *   "text_long",
 *  }
 * )
 */
class DigitaliaTextFormatter extends StringFormatter
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
		$summary[] = $this->t('The values will be displayed separated by "@separator"', ['@separator' => $this->getSetting('separator_option')]);
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

		foreach ($items as $delta => $item) {
			array_push($result, $item->getString());
		}

		$element[0]['#markup'] = implode($separator, $result);
		return $element;
	}
}
