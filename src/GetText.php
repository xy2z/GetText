<?php

	// TODO:
	// - create_label() - should this even be belong here?
	//
	// Possible options
	// - ErrorOnDuplicate - throw error if a new translation is added if it exists (label + instance_key)
	// - Global untranslated text - defaults to '{{label}}~untranslated'.
	// - Fallback to global (instance_key=0) - default True.


	namespace xy2z\GetText;

	/**
	 * GetText
	 *
	 */
	class GetText {

		/**
		 * Loaded translations
		 *
		 * @var array
		 */
		private $translations = array();

		/**
		 * Array of created arrays in the current pageload.
		 * This is to prevent errors when creating a new label in a loop,
		 * since the label is created the first time it shouldn't try to create it again.
		 *
		 * @var array
		 */
		// private $created_labels = array();

		/**
		 * Set translations
		 *
		 * @param array $translations [description]
		 */
		// public function set_translations(array $translations) {
			// foreach ($translations as $row) {
			// 	$this->translations[$row->label][$row->instance_key] = (object) array(
			// 		'translation' => $row->translation
			// 	);
			// }
		// } // get_text_translations()

		public function add_translation(GetTextTranslation $translation) {
			$this->translations[$translation->get_label()][$translation->get_instance_key()] = $translation;
		}

		/**
		 * Get text translation
		 *
		 * @param string $label [description]
		 * @param int|string $instance_key [description]
		 * @param array $replacements [description]
		 * @param bool|boolean $empty_if_untranslated [description]
		 *
		 * @return [type] [description]
		 */
		public function gt(string $label, $instance_key = 0, array $replacements = array(), bool $empty_if_untranslated = false) : string {
			if (empty($label)) {
				throw new Exception('Label cannot be empty');
			}

			$untranslated_text = ($empty_if_untranslated) ? '' : $label . '~untranslated';

			if (!isset($this->translations[$label])) {
				// Label is not created.

				// Create the label, if not created before in current pageload.
				// if (!isset($this->created_labels[$label])) {
				// 	$label_id = $this->create_label($label);
				// }

				return $untranslated_text;
			}

			// Get translation.
			// If the translation exists for the instance_key, use it. Else use the global (instance_key=0).
			if (isset($this->translations[$label][$instance_key])) {
				$translation = $this->translations[$label][$instance_key];
			} else {
			 	// No translation found for this instance_key.
			 	// Use the global translation.
				$translation = $this->translations[$label][0];
			}

			return $translation->get_translation($replacements, $empty_if_untranslated);
		} // gt()

		/**
		 * Create new label
		 *
		 * @param string $label [description]
		 */
		// private function create_label(string $label) {
		// 	// $insert = $this->db->insert('get_text_labels', array(
		// 	// 	'label' => $this->db->clean_string($label)
		// 	// ));

		// 	// if ($insert) {
		// 		// Add the label ID to the $this->translations array.
		// 		$this->created_labels[$label] = true;
		// 	// }
		// } // create_label()


	} // GetText
