<?php

class Debug
{
	public static function dump($data)
	{
		echo '<prd>';
		var_dump($data);
		echo '</prd>';
	}
}