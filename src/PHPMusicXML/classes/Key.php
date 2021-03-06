<?php
namespace ianring;

class Key {
	
	public $properties = array();

	public function __construct($key) {
		if (is_array($key)) {
			$this->properties['fifths'] = $key['fifths'];
			$this->properties['mode'] = $key['mode'];
		} else {
			$this->_resolveKeyString($key);			
		}
	}

	function setProperty($name, $value) {
		$this->properties[$name] = $value;
	}

	/**
	 * accepts a string representation of a key, e.g.:
	 * "C", C Major", "C maj", "Cmaj", "C minor", "C min", "Cmin", "Cmin",
	 * "C-min", "C-minor"
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 */
	private function _resolveKeyString($string) {
		$string = strtolower($string);
		$properties = array(
			'fifths' => 0,
			'mode' => 'major'
		);

		// we could use math, but that's just showing off and it wouldn't be faster
		$keys = array(
			'major' => array(
				'c-' => -7,
				'g-' => -6,
				'd-' => -5,
				'a-' => -4,
				'e-' => -3,
				'b-' => -2,
				'f' => -1,
				'c' => 0,
				'g' => 1,
				'd' => 2,
				'a' => 3,
				'e' => 4,
				'b' => 5,
				'f+' => 6,
				'c+' => 7,
					'd+' => null,
					'e+' => null,
					'f-' => null,
					'g+' => null,
					'a+' => null,
					'b+' => null,
			),
			'minor' => array(
				'a-' => -7,
				'e-' => -6,
				'b-' => -5,
				'f' => -4,
				'c' => -3,
				'g' => -2,
				'd' => -1,
				'a' => 0,
				'e' => 1,
				'b' => 2,
				'f+' => 3,
				'c+' => 4,
				'g+' => 5,
				'd+' => 6,
				'a+' => 7,
					'c-' => null,
					'd-' => null,
					'e+' => null,
					'f-' => null,
					'g-' => null,
					'b+' => null,
			)
		);

		preg_match('/([A-Ga-g+#-b]+?)(.*)/', $string, $matches);
		$chroma = $matches[1];
		$inmode = $matches[2];

		$inmode = trim($inmode);

		$modes = array(
			'major' => array(
				'maj', 'major', ''
			),
			'minor' => array(
				'min', 'minor'
			)
		);

		foreach($modes as $modeName => $modeAliases) {
			if (in_array($inmode, $modeAliases)) {
				$properties['mode'] = $modeName;
			}
		}

		$properties['fifths'] = $keys[$properties['mode']][$chroma];

		$this->properties = $properties;

	}


	function getName() {

	}

	public function toXML() {
		$out = '';
		$out .= '<key>';
		if (isset($this->properties['fifths'])) {
			$out .= '<fifths>' . $this->properties['fifths'] . '</fifths>';
		}
		if (isset($this->properties['mode'])) {
			$out .= '<mode>' . $this->properties['mode'] . '</mode>';
		}
		$out .= '</key>';
		return $out;
	}
}
