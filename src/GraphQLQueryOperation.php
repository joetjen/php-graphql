<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQLQueryOperation
 *
 * @package JOetjen\GraphQL
 */
class GraphQLQueryOperation extends GraphQLOperation {
	/**
	 * GraphQLQuery constructor.
	 *
	 * @param string|null $name
	 */
	public function __construct($name = null) {
		parent::__construct(GraphQL::QUERY, $name);
	}
}
