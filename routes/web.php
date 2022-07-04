<?php

use Illuminate\Support\Facades\Route;
use App\Libs\RedisClient;
use App\Exceptions\Exception;

use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/test",function(){
  
 //todo: you can do your own data then compact to view, I just quick test
 try{

    echo "Test redis connect\r\n<br>";

    $redis= new RedisClient(env("REDIS_HOST"),env("REDIS_PORT"),env("REDIS_PASSWORD"),0) ;

    $redis->Enqueue("nguyen-phan-du","Nguyễn Phan Du ".date(DATE_ATOM));

    $redis->SetCache("hello-world","Nguyễn Phan Du ".date(DATE_ATOM));

    echo $redis->GetCache("hello-world")."\r\n<br>";

}catch (\Exception $ex){        
    echo "ERROR:REDIS: ". $ex->getMessage();
}
try{

    echo "Test mysql connect\r\n<br>";    
   // check: config\database.php 
   $data=DB::connection('mysqlDockerDefault')->select("select * from sys_config");       


   foreach($data as $d){
    echo var_dump( $d) ."\r\n<br>";
   }

}catch (\Exception $ex){        
    echo "ERROR:MYSQL: ". $ex->getMessage();

}

try{

    echo "Test postgress connect\r\n<br>";    
   // check: config\database.php 
   $data=DB::connection('pgsql')->select("select * from tbltest");       


   foreach($data as $d){
    echo var_dump( $d) ."\r\n<br>";
   }

}catch (\Exception $ex){        
    echo "ERROR:pgsql: ". $ex->getMessage();

}
return view('welcome');
});

Route::get('/', function () {
   
    return view('welcome');
});
