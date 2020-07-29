<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLVariable
 *
 * @package JOetjen\GraphQL
 */
class GraphQLVariable extends GraphQLArgument {
	/**
	 * @return array
	 */
	public function asArray() {
		$value = $this->_value !== null
			? $value = $this->_type === GraphQL::STRING ? (string)$this->_value : $this->_value
			: null;

		return array(
			$this->_name => $value,
		);
	}

	/**
	 * @return string
	 */
	public function toString() {
		return "\${$this->_name}:{$this->_type}";
	}
}
