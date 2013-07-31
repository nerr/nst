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
        $costarr = Excel::getCostArr();
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(5);
        $objWorkSheet->fromArray($costarr);


        //-- create charts begin
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
        //-- create profit chart
        $profitchart = Excel::profitChart($sheetArr, count($profitarr));
        $objWorkSheet->addChart($profitchart);
        //-- create swap rate chart
        $swapchart = Excel::swapChart($sheetArr, count($swaparr));
        $objWorkSheet->addChart($swapchart);
        //-- create cost chart
        $swapchart = Excel::costChart($sheetArr, count($costarr));
        $objWorkSheet->addChart($swapchart);
        //-- create charts end


        //-- fund tabel
        $fundtabledata = Excel::getFundTableArr($uid);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(2);
        $objWorkSheet->fromArray($fundtabledata);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('tHeaderFooter'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A1:D2");
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('nAmount'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "C3:C".(count($fundtabledata)));
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('date'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A3:A".(count($fundtabledata)));
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('tGlobal'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "B3:B".(count($fundtabledata)));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "D3:D".(count($fundtabledata)));
        unset($excelstyle);

        //-- profit tabel
        $profittabledata = Excel::getProfitTableArr($uid);
        $objWorkSheet = $objPHPExcel->setActiveSheetIndex(1);
        $objWorkSheet->fromArray($profittabledata);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        /*$excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('tGlobal'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A3:C3");
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A7:D".(count($profittabledata)));
        unset($excelstyle);*/
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('tHeaderFooter'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A1:C2");
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A5:D6");
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('nAmount'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "B7:D".(count($profittabledata)));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A3:B3");
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('nPercent'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "C3");
        unset($excelstyle);
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('date'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A7:A".(count($profittabledata)));
        unset($excelstyle);


        //-- Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '注：本报表由NST系统自动生成，因此可能存在由程序Bug造成的计算错误。');
        $excelstyle = new PHPExcel_Style();
        $excelstyle->applyFromArray(Excel::styleArr('notifi'));
        $objPHPExcel->getActiveSheet()->setSharedStyle($excelstyle, "A1");
        

        //-- output excel
        $filename = 'NST.Weekly.'.date('Y-m-d');
        if($output == 'W')
            Excel::writeXlsxFile($objPHPExcel, $filename);
        elseif($output == 'D')
            Excel::downloadXlsxFile($objPHPExcel, $filename);
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
        $data[] = array('', '掉期', '成本', '收益');

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
        $data = Calculate::getSafeMarginLog();

        foreach($data as $key=>$val)
        {
            $data[$key]['indicator'] = ($val['profitloss'] + $val['commission']) * -1 / $val['balance'] * 100;
        }

        array_unshift($data, array('日期', '', '', '', '成本占用(百分比)'));

        return $data;
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

        //  Build the dataseries
        $series = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART_3D,      // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD,    // plotGrouping
            range(0, count($dataSeriesValues)-1),           // plotOrder
            $dataseriesLabels,                              // plotLabel
            $xAxisTickValues,                               // plotCategory
            $dataSeriesValues                               // plotValues
        );

        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
        //  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

        $title = new PHPExcel_Chart_Title('利息率走势');
        $yAxisLabel = new PHPExcel_Chart_Title('Swap Rate');

        //  Create the chart
        $chart = new PHPExcel_Chart(
            'chart1',       // name
            $title,         // title
            $legend,        // legend
            $plotarea,      // plotArea
            true,           // plotVisibleOnly
            0,              // displayBlanksAs
            NULL,           // xAxisLabel
            $yAxisLabel     // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('A30');
        $chart->setBottomRightPosition('P55');

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

        //  Build the dataseries
        $series = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART_3D,      // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD,    // plotGrouping
            range(0, count($dataSeriesValues)-1),           // plotOrder
            $dataseriesLabels,                              // plotLabel
            $xAxisTickValues,                               // plotCategory
            $dataSeriesValues                               // plotValues
        );

        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
        //  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

        $title = new PHPExcel_Chart_Title('收益情况');
        $yAxisLabel = new PHPExcel_Chart_Title('Profit');

        //  Create the chart
        $chart = new PHPExcel_Chart(
            'chart1',       // name
            $title,         // title
            $legend,        // legend
            $plotarea,      // plotArea
            true,           // plotVisibleOnly
            0,              // displayBlanksAs
            NULL,           // xAxisLabel
            $yAxisLabel     // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('A3');
        $chart->setBottomRightPosition('P27');

        return $chart;
    }

    public static function costChart($sheetArr, $linenum)
    {
        //-- create rate chart
        $dataseriesLabels = array(
            new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[5].'!$E$1', NULL, 1),
        );

        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', $sheetArr[5].'!$A$2:$A$'.$linenum, NULL, 4),
        );

        $dataSeriesValues = array(
            new PHPExcel_Chart_DataSeriesValues('Number', $sheetArr[5].'!$E$2:$E$'.$linenum, NULL, 4),
        );

        //  Build the dataseries
        $series = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART_3D,      // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD,    // plotGrouping
            range(0, count($dataSeriesValues)-1),           // plotOrder
            $dataseriesLabels,                              // plotLabel
            $xAxisTickValues,                               // plotCategory
            $dataSeriesValues                               // plotValues
        );

        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
        //  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

        $title = new PHPExcel_Chart_Title('成本占用 - 点差波动');
        $yAxisLabel = new PHPExcel_Chart_Title('成本占用比率');

        //  Create the chart
        $chart = new PHPExcel_Chart(
            'chart1',       // name
            $title,         // title
            $legend,        // legend
            $plotarea,      // plotArea
            true,           // plotVisibleOnly
            0,              // displayBlanksAs
            NULL,           // xAxisLabel
            $yAxisLabel     // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('A57');
        $chart->setBottomRightPosition('P82');

        return $chart;
    }




    public static function getFundTableArr($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'amount,directioinname,flowtime,memo';
        $criteria->condition='userid=:userid';
        $criteria->params = array(':userid' => $uid);
        $criteria->order  = 'flowtime DESC';
        $result = ViewTaSwapCapitalFlow::model()->findAll($criteria);

        $data[] = array('资金记录');
        $data[] = array('发生时间', '类型', '金额', '说明');
        foreach($result as $val)
        {
            $data[] = array($val->flowtime, Yii::t('common', $val->directioinname), $val->amount, $val->memo);
        }

        return $data;
    }

    public static function getProfitTableArr($uid)
    {
        //-- get report data
        $result = Calculate::getUserReport($uid);

        $data[] = array('汇总');
        $data[] = array('本金', '浮动收益', '浮动收益率');
        $data[] = array($result['summary']['capital'], $result['summary']['yield'], $result['summary']['yieldrate']);

        $data[] = array('');
        //-- table title and header
        $data[] = array('明细 - 每日收益情况报表(最近10天)');
        $data[] = array('日期', '新增掉期', '累计掉期', '总损益');


        //-- format report data for excel
        foreach(array_reverse($result['detail']) as $date=>$val)
        {
            $data[] = array($date, $val['newswap'], $val['totalswap'], $val['totalpl']);
        }

        return $data;
    }

    public static function styleArr($name)
    {
        $style = Excel::getStyleArray();

        $arr = array(
            'tGlobal' => array(
                'borders'   => $style['borders']['general'],
                'font'      => $style['font']['general'],
            ),

            'tHeaderFooter' => array(
                'borders'   => $style['borders']['general'],
                'fill'      => $style['fill']['tHeaderFooter'],
                'font'      => $style['font']['tHeaderFooter'],
            ),

            'nAmount' => array(
                'borders'   => $style['borders']['general'],
                'font'      => $style['font']['general'],
                'numberformat'=> $style['numberformat']['amount'],
            ),
            'nPercent' => array(
                'borders'   => $style['borders']['general'],
                'font'      => $style['font']['general'],
                'numberformat'=> $style['numberformat']['percent'],
            ),

            'date' => array(
                'borders'   => $style['borders']['general'],
                'font'      => $style['font']['general'],
                'numberformat'=> $style['numberformat']['date'],
            ),

            'notifi' => array(
                'font'      => $style['font']['tHeaderFooter'],
            ),
        );

        return $arr[$name];
    }


    public static function getStyleArray()
    {
        return array(
            'borders' => array(
                'general' => array(
                    'bottom'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'left'      => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'top'       => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                ),
            ),

            'fill' => array(
                'tHeaderFooter'  => array(
                    'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                    'color'     => array('argb' => 'D4FF55'),
                ),
            ),

            'font' => array(
                'general' => array(
                    'name'      => 'Microsoft YaHei',
                    'size'      => 9, 
                    'bold'      => false,
                ),
                'tHeaderFooter' => array(
                    'name'      => 'Microsoft YaHei',
                    'size'      => 10, 
                    'bold'      => true,
                ),
            ),

            'numberformat' => array(
                'amount' => array(
                    'format'    => PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD,
                ),
                'percent' => array(
                    'format'    => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE,
                ),
                'date' => array(
                    'format'    => PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2,
                ),
                'datetime' => array(
                    'format'    => PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2,
                ),
            ),
        );
    }
}