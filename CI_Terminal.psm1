function CI($method,$filetype,$tablename)
{
    if([string]::IsNullOrEmpty($method) -or [string]::IsNullOrEmpty($filetype)  -or [string]::IsNullOrEmpty($tablename) )
    {
       echo 'Invalid Command. Read documentation for reference'
    }
    else
    {

    $pathNotFound_Err = 'Path not found. Make sure to open terminal on system base path'
    if($method -eq 'CREATE')
    {
        if($filetype -eq 'MIGRATION')
        {
          if(Test-Path .\application\migrations)
          {
            create-migration($tablename)
          }
          else
          {
            echo $pathNotFound_Err
          }
        }
        elseif($filetype -eq 'CONTROLLER')
        {
          if(Test-Path .\application\controllers)
          {
            create-controller($tablename)
          }
          else
          {
            echo $pathNotFound_Err
          }
        }
        elseif($filetype -eq 'MODEL')
        {
          if(Test-Path .\application\models)
          {
            create-model($tablename)
          }
          else
          {
            echo echo $pathNotFound_Err
          }
        }
      }
      }
}

function create-migration($tablename)
{
          $timestamp = Get-date -f yyyyMMddHHmmss
          $filename = -join($timestamp,'_add_',$tablename,'_table.php')
          $classname = -join('Migration_add_',$tablename,'_table')
          
          if(Test-Path .\application\migrations\$filename)
          {
            echo 'Filename already exist'
          }
          else
          {

          New-Item .\application\migrations\$filename
          Set-Content .\application\migrations\$filename "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class $classname extends CI_Migration 
{
  public function up()
  {
    //Table fields
  }

  public function down()
  {
    //Table name
  }
}"
          }
          
}


function create-controller($tablename)
{
        $filename = -join($tablename,'_Controller.php')
        $classname = -join($tablename,'_Controller')

          if(Test-Path .\application\controllers\$filename)
          {
            echo 'Filename already exist'
          }
          else
          {

        New-Item .\application\controllers\$filename
        Set-Content .\application\controllers\$filename "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class $classname extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }
}"
        }
}


function create-model($tablename)
{
          if(Test-Path .\application\models\$filename)
          {
            echo 'Filename already exist'
          }
          else
          {
        $filename = -join($tablename,'_Model.php')
        $classname = -join($tablename,'_Model')
        New-Item .\application\models\$filename
        Set-Content .\application\models\$filename "<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class $classname extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }
}"
        }
}