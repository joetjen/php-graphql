<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLOperation
 *
 * @package JOetjen\GraphQL
 */
class GraphQLOperation extends GraphQLField {
	protected $_type;

	/**
	 * GraphQLQuery constructor.
	 *
	 * @param string|null $name
	 */
	public function __construct($type, $name = null) {
		parent::__construct($name);

		$this->_type = $type;
	}

	/**
	 * @param string                 $name
	 * @param mixed|GraphQLVariable $value
	 * @param string                 $type
	 *
	 * @return GraphQLQueryOperation|void
	 * @throws GraphQLException
	 */
	public function argument($name, $value, $type = GraphQL::STRING) {
		throw new GraphQLException('Queries cannot have an arguments, use variables instead!');
	}

	/**
	 * @return string
	 */
	public function toString() {
		$this->_args = $this->variables();

		$gql = $this->_type;

		if ($this->_name !== null) {
			$gql .= ' ';
		}

		$gql .= parent::toString();

		return $gql;
	}
}
