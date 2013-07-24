<?php

class Excel
{
	public static function weekly($uid, $output = 'W')
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
		$swaparr = Excel::getSwapRateArr();
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(3);
		$objWorkSheet->fromArray($swaparr);

		//-- fill profit chart data
		$profitarr = Excel::getProfitArr($data['charts']);
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(4);
		$objWorkSheet->fromArray($profitarr);

		//-- fill cost chart data
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(5);
		//$objWorkSheet->fromArray(Excel::getCostArr()); //--todo

		//-- create charts begin
		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
		//-- create swap rate chart
		$profitchart = Excel::profitChart($sheetArr, count($profitarr));
		$objWorkSheet->addChart($profitchart);
		//-- create swap rate chart
		$swapchart = Excel::swapChart($sheetArr, count($swaparr));
		$objWorkSheet->addChart($swapchart);
		//-- create charts end




		//-- Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		//-- output excel
		if($output == 'W')
			Excel::writeXlsxFile($objPHPExcel, 'test');
		elseif($output == 'D')
			Excel::downloadXlsxFile($objPHPExcel, 'test');
	}

	public static function writeXlsxFile($obj, $name, $debug = false)
	{
		if($debug == true)
			echo date('H:i:s') , " Write to Excel2007 format" , EOL;

		$objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save(Yii::app()->params->xlsxPath.$name.'.xlsx');

		if($debug == true)
		{
			echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo($savepath, PATHINFO_BASENAME)) , EOL;
			// Echo memory peak usage
			echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

			// Echo done
			echo date('H:i:s') , " Done writing file" , EOL;
			echo 'File has been created in ' , getcwd() , EOL;
		}
		exit;
	}


	public static function downloadXlsxFile($obj, $name)
	{
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
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



	/*charts*/
	public static function swapChart($sheetArr, $linenum)
	{
		//-- create rate chart
		$dataseriesLabels = array(
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$B$1', NULL, 1),
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$D$1', NULL, 1),
			/*new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$F$1', NULL, 1),
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$H$1', NULL, 1),
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$J$1', NULL, 1),*/
		);

		$xAxisTickValues = array(
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[3].'!$A$2:$A$'.$linenum, NULL, 4),
		);

		$dataSeriesValues = array(
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[3].'!$C$2:$C$'.$linenum, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[3].'!$E$2:$E$'.$linenum, NULL, 4),
			/*new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[3].'!$G$2:$G$'.$linenum, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[3].'!$H$2:$H$'.$linenum, NULL, 4),
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[3].'!$J$2:$J$'.$linenum, NULL, 4)*/
		);

		//	Build the dataseries
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues)-1),			// plotOrder
			$dataseriesLabels,								// plotLabel
			$xAxisTickValues,								// plotCategory
			$dataSeriesValues								// plotValues
		);

		//	Set the series in the plot area
		$plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
		//	Set the chart legend
		$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

		$title = new PHPExcel_Chart_Title('利息率走势');
		$yAxisLabel = new PHPExcel_Chart_Title('Swap Rate');

		//	Create the chart
		$chart = new PHPExcel_Chart(
			'chart1',		// name
			$title,			// title
			$legend,		// legend
			$plotarea,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel		// yAxisLabel
		);

		//	Set the position where the chart should appear in the worksheet
		$chart->setTopLeftPosition('A16');
		$chart->setBottomRightPosition('N30');

		return $chart;
	}


	public static function profitChart($sheetArr, $linenum)
	{
		//-- create rate chart
		$dataseriesLabels = array(
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[4].'!$B$1', NULL, 1),
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[4].'!$C$1', NULL, 1),
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[4].'!$D$1', NULL, 1),
		);

		$xAxisTickValues = array(
			new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[4].'!$A$2:$A$'.$linenum, NULL, $linenum-1),
		);

		$dataSeriesValues = array(
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[4].'!$B$2:$B$'.$linenum, NULL, $linenum-1),
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[4].'!$C$2:$C$'.$linenum, NULL, $linenum-1),
			new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[4].'!$D$2:$D$'.$linenum, NULL, $linenum-1),
		);

		//	Build the dataseries
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
			range(0, count($dataSeriesValues)-1),			// plotOrder
			$dataseriesLabels,								// plotLabel
			$xAxisTickValues,								// plotCategory
			$dataSeriesValues								// plotValues
		);

		//	Set the series in the plot area
		$plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
		//	Set the chart legend
		$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

		$title = new PHPExcel_Chart_Title('收益情况');
		$yAxisLabel = new PHPExcel_Chart_Title('Profit');

		//	Create the chart
		$chart = new PHPExcel_Chart(
			'chart1',		// name
			$title,			// title
			$legend,		// legend
			$plotarea,		// plotArea
			true,			// plotVisibleOnly
			0,				// displayBlanksAs
			NULL,			// xAxisLabel
			$yAxisLabel		// yAxisLabel
		);

		//	Set the position where the chart should appear in the worksheet
		$chart->setTopLeftPosition('A1');
		$chart->setBottomRightPosition('N15');

		return $chart;
	}
}