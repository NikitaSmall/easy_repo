<?php

/**
 *
 */
interface BaseModelInterface
{
  const HELLO_CONST = 'hello';

  public function dbName();
}


abstract class BaseModel implements BaseModelInterface
{
  private $dbInst;

  abstract public function getBD();

  public function dbConnectString()
  {
    return 'connect_string';
  }
}

abstract class MongoModel extends BaseModel
{
  abstract public function getCollectionName();
}

class MySQLModel extends BaseModel
{
  public function dbName()
  {
    return 'mysql_Db';
  }

  public function getBD()
  {
    return 'mysql';
  }
}

class MSSQL extends BaseModel
{
  public function getBD()
  {
    return 'mssql';
  }

  public function dbName()
  {
    return 'mssqlDB';
  }
}

# $model = new MongoModel();
# var_dump($model->dbConnectString());

function printConnectDB(BaseModel $model)
{
  echo $model->getBD();
}

$m = new MSSQL();
printConnectDB($m);
