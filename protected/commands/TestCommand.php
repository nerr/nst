<?php

class TestCommand extends CConsoleCommand
{
    public function run($args)
    {
        /*$criteria = new CDbCriteria;
        $criteria->select = 'id,mobile';
        $criteria->condition='id in (1,5)';
        $result = SysUser::model()->findAll($criteria);*/

        /*foreach($result as $val)
        {
            $data = Calculate::getGeneralSummaryData($val->id);

            $msg = '截止'.$data['summary']['lastuptodate']."\r";
            $msg .= '账户余额: '.number_format($data['summary']['balance'], 2)."\r";
            $msg .= '交易成本: '.number_format($data['summary']['cost'], 2)."\r";
            $msg .= '累计获得掉期: '.number_format($data['summary']['swap'], 2)."\r";
            $msg .= '浮动收益: '.number_format($data['summary']['netearning'], 2);
            $msg .= '[NST自动短信报表]';

            //$m = echo mb_convert_encoding($msg, 'GBK', 'UTF-8');
            echo $msg;
            $this->sendSms($val->mobile, $msg);
        }*/

        $un = 5;
        $data = Calculate::getGeneralSummaryData($un);

        $msg = '截止'.$data['summary']['lastuptodate']."\r\n";
        $msg .= '账户余额: '.number_format($data['summary']['balance'], 2)."\r\n";
        $msg .= '交易成本: '.number_format($data['summary']['cost'], 2)."\r\n";
        $msg .= '累计获得掉期: '.number_format($data['summary']['swap'], 2)."\r\n";
        $msg .= '浮动收益: '.number_format($data['summary']['netearning'], 2)."\r\n";
        if(($data['summary']['balance'] - $data['summary']['netearning']) > 0)
            $msg .= '收益率: '.number_format($data['summary']['netearning']/($data['summary']['balance'] - $data['summary']['netearning'])*100, 2).'%'."\r\n";;
        $msg .= '[NST自动短信报表]';

        //$m = echo mb_convert_encoding($msg, 'GBK', 'UTF-8');
        echo $msg;
        //Notification::nSendSms('13524289996', $msg);
        Notification::nSmsfetion('13524289996', $msg);
    }


}