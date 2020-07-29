<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLArgument
 *
 * @package JOetjen\GraphQL
 */
class GraphQLArgument {
	protected $_name;
	protected $_type;
	protected $_value;

	/**
	 * GraphQLArgument constructor.
	 *
	 * @param string                 $name
	 * @param mixed|GraphQLVariable $value
	 * @param string                 $type
	 */
	public function __construct($name, $value = null, $type = GraphQL::STRING) {
		$this->_name = $name;

		$this->setValue($value);
		$this->setType($type);
	}

	/**
	 * @param mixed|GraphQLVariable $value
	 *
	 * @return $this
	 */
	public function setValue($value) {
		$this->_value = $value;

		return $this;
	}

	/**
	 * @return GraphQLVariable|null
	 */
	public function variable() {
		if ($this->_value instanceof GraphQLVariable /* && $this->_value->_value !== null */) {
			return $this->_value;
		}

		return null;
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function setType($type) {
		$this->_type = $type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function toString() {
		$gql = '';

		if ($this->_value !== null) {
			if ($this->_value instanceof GraphQLVariable) {
				$gql .= "{$this->_name}:\${$this->_value->_name}";
			} else {
				$gql .= "{$this->_name}:";

				if ($this->_type === GraphQL::STRING) {
					$gql .= "\"{$this->_value}\"";
				} else {
					$gql .= $this->_value;
				}
			}
		}

		return $gql;
	}
}
