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
		$n_data = array();
		$keys = array_keys($data);
		$len = count($data[$keys[0]]);

		for ($i=0; $i < $len; $i++) {
			$array = array(
				'hour'  =>  $data[$keys[0]][$i]['hour']
			);
			foreach ($keys as $key) {
				$k = str_replace(' ', '', $key);
				$array[$k] = $data[$key][$i]['mount'];
			}

			$n_data[] = $array;
		}

		return $n_data;
	}

	public static function parseGeneralToChart($data, $direction) {
		$n_data = array();
		$keys = array_keys($data);
		$len = count($data[$keys[0]][$direction]);

		for ($i=0; $i < $len; $i++) {
			$array = array(
				'hour'  =>  $data[$keys[0]][$direction][$i]['hour']
			);

			foreach ($keys as $key) {
				$array[$key] = $data[$key][$direction][$i]['mount'];
			}
			$n_data[] = $array;
		}
		return $n_data;
	}
}