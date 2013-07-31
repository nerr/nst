<?php

class Debug
{
	public static function dump($data)
	{
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}
}