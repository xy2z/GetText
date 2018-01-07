<?php

	namespace xy2z\GetText;


	class GetTextTranslation {

		private $label;

		/**
		 * Instance key
		 *
		 * @var Can be int or string. Int 0 is reserved for default/global.
		 */
		private $instance_key;

		private $translation;


		public function __construct(string $label, $instance_key, string $translation) {
			$this->label = $label;
			$this->instance_key = $instance_key;
			$this->translation = $translation;
		}


		public function get_label() {
			return $this->label;
		}


		public function get_instance_key() {
			return $this->instance_key;
		}


		public function get_translation(array $replacements, bool $empty_if_untranslated) {
			$translation = $this->translation;

			// Replacements.
			foreach ($replacements as $key => $value) {
				$translation = str_replace('{{' . $key . '}}', $value, $translation);
			}

			return $translation;
		}

	}
