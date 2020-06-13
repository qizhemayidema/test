<?php

use xingwenge\canal_php\CanalClient;
use xingwenge\canal_php\CanalConnectorFactory;
use xingwenge\canal_php\Fmt;
#use Com\Alibaba\Otter\Canal\Protocol\Column;
#use Com\Alibaba\Otter\Canal\Protocol\Entry;
#use Com\Alibaba\Otter\Canal\Protocol\EntryType;
use Com\Alibaba\Otter\Canal\Protocol\EventType;
use Com\Alibaba\Otter\Canal\Protocol\RowChange;
#use Com\Alibaba\Otter\Canal\Protocol\RowData;

require './vendor/autoload.php';

try {
    $client = CanalConnectorFactory::createClient(CanalClient::TYPE_SOCKET_CLUE);
    # $client = CanalConnectorFactory::createClient(CanalClient::TYPE_SWOOLE);

    $client->connect("127.0.0.1", 11111);
    $client->checkValid();
    $client->subscribe("1001", "example", ".*\\..*");
    # $client->subscribe("1001", "example", "db_name.tb_name"); # 设置过滤

    while (true) {
        $message = $client->get(100);
        if ($entries = $message->getEntries()) {
            foreach ($entries as $entry) {
		
                $rowChange = new RowChange();
        	$rowChange->mergeFromString($entry->getStoreValue());
		$tableName = $entry->getHeader()->getTableName();
                  // $str =  $obj->getSql(); 
		foreach($rowChange->getRowDatas() as $key => $value)
		{
			$sql = getSql($rowChange->getEventType(),$tableName,$value);
			echo $sql;

			 $sqlite = new Sqlite();
			 $sqlite->exec($sql);
		}
		//$eventType = $rowChange->getEventType();
		   
		//Fmt::println($entry);            
            }
        }
        sleep(1);
    }

    $client->disConnect();
} catch (\Exception $e) {
    echo $e->getMessage(),$e->getLine(),$e->getFIle(), PHP_EOL;
}


function getSql($eventType,$tableName,$rowData)
{
	$sql = null;
	switch($eventType){
		case EventType::INSERT:
			$sql = getInsertSql($tableName,$rowData->getAfterColumns());
		break;
		case EventType::DELETE:
			$sql = getDeleteSql($tableName,$rowData->getBeforeColumns());
		break;
		default:
			$sql = getUpdateSql($tableName,$rowData->getAfterColumns());
		break;
	}

	return $sql;

}

function getInsertSql($tableName,$columns)
{
	$keys = "";
	$values = "";

	foreach($columns as $key => $column)
	{
		$keys .= $column->getName();
                $tempValue = $column->getValue();
		
		
		$values .= is_numeric($tempValue) ? $tempValue : "'" . $tempValue  . "'"; 
	

		if($key != (count($columns) - 1))
		{
			$keys .= ",";
			$values .= ",";
		}
		
	}
	/* for($i=0;$i<count($columns);$i++){
            if($i != 0) {
                $keys .= ",";
                $values .= ",";
            }
            $keys .= $columns->get($i)->getName();
            $values .= getValue($columns->get($i));
        }*/

	$sql = "INSERT INTO {$tableName} ($keys) VALUES ($values)";
	return $sql;
}

function getValue($column)
{
	if(is_null($column)){
		return "null";
	}
	var_dump($column->getValue);
	return $column->getValue();
}


//sqlite
class Sqlite extends SQLite3
{
  function __construct()
      {
         $this->open('test01.db');
      }	
}
