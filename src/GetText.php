<?php


	namespace xy2z\GetText;

	/**
	 * GetText
	 *
	 */
	class GetText {

		/**
		 * Loaded translations
		 * Array of GetTextTranslation instances.
		 *
		 * @var array
		 */
		private $translations = array();

		/**
		 * The anonymous function to be called when a new label is found.
		 * This can be useful for creating it in the database.
		 *
		 * @var function
		 */
		public $create_label_function = null;


		/**
		 * Array of created arrays in the current pageload.
		 * This is to prevent errors when creating a new label in a loop,
		 * since the label is created the first time it shouldn't try to create it again.
		 *
		 * @var array
		 */
		private $created_labels = array();

		/**
		 * Add translation
		 *
		 * @param string $label Label name.
		 * @param string|int $instance_key Instance key.
		 * @param mixed $translation The translated text.
		 */
		public function add_translation(string $label, $instance_key, $translation) {
			if (is_null($instance_key)) {
				$instance_key = 0;
			}
			$this->translations[$label][$instance_key] = new GetTextTranslation($label, $instance_key, $translation);
		}

		/**
		 * Get text translation
		 *
		 * @param string $label
		 * @param int|string $instance_key
		 * @param array $replacements
		 * @param bool|boolean $empty_if_untranslated
		 *
		 * @return string The translated text if found.
		 */
		public function gt(string $label, $instance_key = 0, array $replacements = array(), bool $empty_if_untranslated = false) : string {
			if (empty($label)) {
				throw new Exception('Label cannot be empty');
			}

			$untranslated_text = ($empty_if_untranslated) ? '' : $label . '~untranslated';

			if (!isset($this->translations[$label])) {
				// Label is not created.

				// Create the label, if not created before in current pageload.
				if (isset($this->create_label_function) && (!isset($this->created_labels[$label]))) {
					// Call the anonymous function.
					call_user_func($this->create_label_function, $label);
					$this->created_labels[$label] = true;
				}

				return $untranslated_text;
			}

			// Get translation.
			// If the translation exists for the instance_key, use it. Else use the global (instance_key=0).
			if (isset($this->translations[$label][$instance_key])) {
				$gt_translation = $this->translations[$label][$instance_key];
			} else {
			 	// No translation found for this instance_key.
			 	// Use the global translation.
				$gt_translation = $this->translations[$label][0];
			}

			return $gt_translation->get_translation($replacements, $empty_if_untranslated);
		} // gt()


	} // GetText
