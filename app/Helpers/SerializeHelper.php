<?php

namespace App\Helpers;


class SerializeHelper
{
	public static function fromArray($data, $parameters)
	{
		$results = array();
		foreach ($data as $item) {
			$result = array();
			foreach ($parameters as $parameter) {
				$result[$parameter] = $item->{$parameter};
			}
			$results[] = $result;
		}
		return $results;
	}

	public static function parseToChart($data)
	{
		dd($data);
	}
}