<?php

namespace JOetjen\GraphQL;

/**
 * Class GraphQL
 *
 * @package JOetjen\GraphQL
 */
class GraphQL extends GraphQLField {
	const QUERY = 'query';

	const INT     = 'Int';
	const FLOAT   = 'Float';
	const STRING  = 'String';
	const BOOLEAN = 'Boolean';
	const ID      = 'ID';

	/**
	 * @return GraphQLDocument
	 */
	public static function create() {
		return new GraphQLDocument();
	}
}
