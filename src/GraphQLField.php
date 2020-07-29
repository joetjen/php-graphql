<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLField
 *
 * @package JOetjen\GraphQL
 */
class GraphQLField {
	protected $_name;
	protected $_alias;
	protected $_nodes = array();
	protected $_args  = array();

	/**
	 * GraphQLField constructor.
	 *
	 * @param string $name
	 */
	public function __construct($name) {
		$this->_name = $name;
	}

	/**
	 * @param string        $name
	 * @param null|callable $func callable(GraphQLField)
	 *
	 * @return $this
	 */
	public function select($name, $func = null) {
		if (is_callable($name)) {
			$func = $name;
			$name = null;
		}

		$field = new GraphQLField($name);

		if (is_callable($func)) {
			$func($field);
		}

		$this->add($field);

		return $this;
	}

	/**
	 * @param string $alias
	 *
	 * @return $this
	 */
	public function alias($alias) {
		$this->_alias = $alias;

		return $this;
	}

	/**
	 * @param string                 $name
	 * @param mixed|GraphQLVariable $value
	 * @param string                 $type
	 *
	 * @return $this
	 */
	public function argument($name, $value, $type = GraphQL::STRING) {
		$this->_args[$name] = new GraphQLArgument($name, $value, $type);

		return $this;
	}

	/**
	 * @param GraphQLField $node
	 *
	 * @return $this
	 */
	protected function add(GraphQLField $node) {
		$this->_nodes[] = $node;

		return $this;
	}

	/**
	 * @return array
	 */
	protected function variables() {
		$variables = array();

		if (!empty($this->_args)) {
			foreach ($this->_args as $name => $arg) {
				/** @var GraphQLArgument $arg */
				$variable = $arg->variable();

				if ($variable !== null) {
					$variables[$name] = $variable;
				}
			}
		}

		$variables = array($variables);

		if (!empty($this->_nodes)) {
			foreach ($this->_nodes as $node) {
				/** @var GraphQLField $node */
				$variables[] = $node->variables();
			}
		}

		$variables = call_user_func_array('array_merge', $variables);

		return $variables;
	}

	/**
	 * @return string
	 */
	public function toString() {
		$gql = '';

		if ($this->_name !== null) {
			if ($this->_alias !== null) {
				$gql .= "{$this->_alias}:";
			}

			$gql .= $this->_name;
		}

		if ( ! empty($this->_args)) {
			$gql .= '(';

			$args = $this->_args;
			$vals = array_map(function ($key) use ($args) {
				$arg = $args[$key];

				if (is_string($arg)) {
					return "{$key}:{$arg}";
				}

				return $arg->toString();
			}, array_keys($this->_args));

			$vals = array_filter($vals, function ($val) {
				return ! (empty($val) && $val !== 0);
			});

			$gql .= implode(',', $vals);

			$gql .= ')';
		}

		if ( ! empty($this->_nodes)) {
			$gql .= '{';

			$vals = array_map(function ($node) {
				return $node->toString();
			}, $this->_nodes);

			$vals = array_filter($vals, function ($val) {
				return ! (empty($val) && $val !== 0);
			});

			$gql .= implode(',', $vals);

			$gql .= '}';
		}

		return $gql;
	}
}
