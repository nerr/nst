<?php

class Notification()
{
	public static function nSmsfetion($mobile, $msg)
	{
		$fetion = new PHPFetion($this->_mobile, $this->_password);
		try
		{
			$result = $fetion->send($mobile, $this->_smsTextPrefix.$msg.$this->_smsTextSuffix);
			$count = 0;
			while(!$this->checkStatus($result) && $count < $this->_trytime )
			{
				$count++;
				sleep(2);
				//echo "Sleep 2s, Re Send\n";
				$result = $result = $fetion->send($mobile, $this->_smsTextPrefix.$msg.$this->_smsTextSuffix);
			}
			if ($count != ($this->_trytime - 1))
			{
				//echo "Date:".date('Y-m-d H:i:s', time()).";Finished\n";
				return true;
			}
			else
			{
				//echo "Date:".date('Y-m-d H:i:s', time()).";Failed\n";
				return false;
			}
		}
		catch( Exception $e)
		{
			//echo "Date:".date('Y-m-d H:i:s', time()).";ERROR:".$e."\n";
			return false;
		}
	}
}