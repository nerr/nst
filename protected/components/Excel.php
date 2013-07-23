<?php

class Excel
{
	public static function weekly($uid)
	{
		//-- init
		Yii::import('ext.phpexcel.XPHPExcel');      
		$objPHPExcel = XPHPExcel::createPHPExcel();

		$sheetId = 0;

		//-- Set document properties
		$objPHPExcel->getProperties()->setCreator("NST")
									 ->setLastModifiedBy("NST")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Auto report powered by NST")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Powered by NST");

		//-- create and set sheets name			 
		$sheetArr = array(
			0 => 'Chart',
			1 => 'ProfitTable',
			2 => 'FundTable',
			3 => 'SwapRateChartData',
			4 => 'ProfitChartData',
			5 => 'CostChartData'
		);
		foreach($sheetArr as $sheetId=>$sheetName)
		{
			if($sheetId == 0)
			{
				$objPHPExcel->setActiveSheetIndex($sheetId);
				$objPHPExcel->getActiveSheet()->setTitle('Chart');
			}
			else
			{
				$objWorkSheet = $objPHPExcel->createSheet($sheetId);
				$objPHPExcel->setActiveSheetIndex($sheetId);
				$objPHPExcel->getActiveSheet()->setTitle($sheetName);
			}
		}

		$data = Calculate::getGeneralSummaryData($uid);

		//-- fill swap rate chart data
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(3);
		$objWorkSheet->fromArray(Excel::getSwapRateArr());

		//-- fill profit chart data
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(4);
		$objWorkSheet->fromArray(Excel::getProfitArr($data['charts']));

		//-- fill cost chart data
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(5);
		//$objWorkSheet->fromArray(Excel::getCostArr());


		//-- create rate chart
		











		// Add some data
		/*$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Hello')
					->setCellValue('B2', 'world!')
					->setCellValue('C1', 'Hello')
					->setCellValue('D2', 'world!');*/
		//$objWorksheet = $objPHPExcel->getActiveSheet();



		//-- Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		Excel::renderXlsxFile($objPHPExcel, 'test');
	}


	public static function renderXlsxFile($obj, $name)
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
		$objWriter->save('php://output');

		exit;
	}

	public static function getSwapRateArr()
	{
		$aid = 2; //-- account id
		$sr[] = array('', 'SymbolA','', 'SymbolB','', 'SymbolC','', 'SymbolD','', 'SymbolE','');

		$criteria = new CDbCriteria;
		$criteria->select ='symbol,logdatetime,longswap,shortswap';
		$criteria->condition = 'accountid=:accountid';
		$criteria->order = 'logdatetime';
		$criteria->params = array(':accountid' => $aid);
		$result = TaSwapRate::model()->findAll($criteria);

		foreach($result as $val)
		{
			$logdate = date('Y-m-d', strtotime($val->logdatetime));

			$swaprate[$logdate][$val->symbol] = array($val->longswap, $val->shortswap);
		}

		foreach($swaprate as $date=>$symbol)
		{
			$sr[] = array($date, 
						  $symbol['EURMXN'][0], $symbol['EURMXN'][1], 
						  $symbol['USDMXN'][0], $symbol['USDMXN'][1],
						  $symbol['MXNJPY'][0], $symbol['MXNJPY'][1],
						  $symbol['USDJPY'][0], $symbol['USDJPY'][1],
						  $symbol['EURJPY'][0], $symbol['EURJPY'][1]
						  );
		}

		return $sr;
	}

	public static function getProfitArr($arr)
	{
		$data[] = array('', 'swap', 'cost', 'netearning');

		foreach($arr as $key=>$val)
		{
			foreach($val as $v)
			{
				$date = date('Y-m-d', $v[0]);
				$d[$date][$key] = $v[1];
			}
		}

		foreach($d as $date=>$v)
		{
			$data[] = array($date,
							$d[$date]['swap'],
							$d[$date]['cost'],
							$d[$date]['netearning']
						    );
		}

		return $data;
	}

	public static function getCostArr()
	{

	}
}