<?php

	namespace xy2z\GetText;


	class GetTextTranslation {

		/**
		 * The translation label
		 *
		 * Label + instance_key each have a translation.
		 *
		 * @var string
		 */
		private $label;

		/**
		 * Instance key
		 *
		 * @var Can be int or string. Int 0 is reserved for default/global.
		 */
		private $instance_key;

		/**
		 * The translated text
		 *
		 * @var string
		 */
		private $translation;

		/**
		 * Constructor
		 *
		 * @param string $label Translation label
		 * @param string|int $instance_key The instance ID/key.
		 * @param mixed $translation Translated text.
		 */
		public function __construct(string $label, $instance_key, $translation) {
			$this->label = $label;
			$this->instance_key = $instance_key;
			$this->translation = $translation;
		}

		/**
		 * Get translated text with replacements
		 *
		 * @param array $replacements Replacements without { or }.
		 * @param bool $empty_if_untranslated If translation doesn't exists.
		 *
		 * @return string The translated text.
		 */
		public function get_translation(array $replacements, bool $empty_if_untranslated) {
			$translation = $this->translation;

			if (is_null($translation) || $translation == '') {
				if ($empty_if_untranslated) {
					return '';
				}
				return $this->label . '~untranslated';
			}

			// Replacements.
			foreach ($replacements as $key => $value) {
				$translation = str_replace('{{' . $key . '}}', $value, $translation);
			}

			return $translation;
		}

	}
