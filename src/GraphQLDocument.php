<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLDocument
 *
 * @package JOetjen\GraphQL
 */
class GraphQLDocument extends GraphQLField {
	/**
	 * GraphQLRoot constructor.
	 */
	public function __construct() {
		parent::__construct(null);
	}

	/**
	 * @param string        $name
	 * @param null|callable $func callable(GraphQLQueryOperation)
	 *
	 * @return $this
	 */
	public function query($name, $func = null) {
		if (is_callable($name)) {
			$func = $name;
			$name = null;
		}

		$query = new GraphQLQueryOperation($name);

		if (is_callable($func)) {
			$func($query);
		}

		$this->add($query);

		return $this;
	}

	/**
	 * @param string $alias
	 *
	 * @return GraphQLDocument|void
	 * @throws GraphQLException
	 */
	public function alias($alias) {
		throw new GraphQLException('Queries cannot have an alias!');
	}

	/**
	 * @param string                 $name
	 * @param mixed|GraphQLVariable $value
	 * @param string                 $type
	 *
	 * @return GraphQLDocument|void
	 * @throws GraphQLException
	 */
	public function argument($name, $value, $type = GraphQL::STRING) {
		throw new GraphQLException('Queries cannot have an arguments, use variables instead!');
	}

	/**
	 * @return array
	 */
	public function variables() {
		$variables = array();

		if ( ! empty($this->_nodes)) {
			foreach ($this->_nodes as $node) {
				/** @var GraphQLField $node */
				$variables[] = $node->variables();
			}
		}

		$variables = call_user_func_array('array_merge', $variables);

		$variables = array_reduce($variables, function ($acc, $variable) {
			/** @var GraphQLVariable $variable */
			$acc[] = $variable->asArray();

			return $acc;
		}, array());

		$variables = call_user_func_array('array_merge', $variables);

		$variables = array_filter($variables, function ($variable) {
			return $variable !== null;
		});

		return $variables;
	}

	/**
	 * @return string
	 */
	public function toString() {
		$gql = '';

		if ( ! empty($this->_nodes)) {
			foreach ($this->_nodes as $node) {
				$gql .= $node->toString();
			}
		}

		return $gql;
	}
}
