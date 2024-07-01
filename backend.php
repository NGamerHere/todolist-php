<?php

session_start();
//error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_USER_WARNING & ~E_USER_NOTICE & ~E_STRICT);
$host = '10.101.136.43';
$port = 27017;
$username = 'ctt_sample';
$password = 'ctt_sample';
$database = 'ctt_sample';
require 'vendor/autoload.php';
use MongoDB\Client;
use MongoDB\BSON\ObjectId;
try {
    $client = new MongoDB\Client(
        'mongodb://ctt_sample:ctt_sample@10.101.136.43:27017/company?authSource=admin'
    );
} catch (Exception $e) {
    echo "Failed to connect to MongoDB: " . $e->getMessage();
    exit;
}
$collection=$client->selectDatabase('ctt_sample')->selectCollection("sairamkumar_users");
$tasks=$client->selectDatabase('ctt_sample')->selectCollection('sairamkumar_tasks');

if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST['action']=='registration'){
            $username=$_POST['username'];
            $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
            $name=$_POST['name'];

            $emailCheck=$collection->findOne([
                'username'=>$username,
            ]);

            if($emailCheck){
              echo json_encode(['message'=>'emailAlreadyThere']);
              exit();
            }

            $result=$collection->insertOne([
                'username'=>$username,
                'password'=>$password,
                'name'=>$name
            ]);
            if($result->getInsertedCount() >0){
                echo json_encode(['message'=>'done']);
            }else{
                echo json_encode(['message'=>'interServerError']);
            }


    }elseif ($_POST['action']== 'login'){
         $username=$_POST['username'];
         $password=$_POST['password'];
          $searchResult=$collection->findOne([
             'username'=>$username
          ]);
          if($searchResult){
              if(password_verify($password , $searchResult['password'])){
                   $_SESSION['name']=$searchResult['name'];
                   $_SESSION['id']=$searchResult['_id'];
                  echo json_encode(['message'=>'done']);
              }else{
                  echo json_encode(['message'=>'passwordWrong']);
              }
          }else{
              echo json_encode(['message'=>'usernameNotFound']);
          }


        }
          elseif ($_POST['action']=='addNewTask'){
               $taskName=$_POST['taskName'];
               $taskDescription=$_POST['taskDescription'];
               $_id=$_SESSION['id'];
               $newID=new MongoDB\BSON\ObjectId($_id);

               $result=$tasks->insertOne([
                   'taskName'=>$taskName,
                   'taskDescription'=>$taskDescription,
                   'userid'=>$newID,
               ]);
               if($result->getInsertedCount() > 0){
                   echo json_encode(['message'=>'done']);
               }else{
                   echo json_encode(['message'=>'internalServerError']);
               }

          }
        elseif ($_POST['action']==='editTask'){
            $taskName=$_POST['taskName'];
            $taskDescription=$_POST['taskDescription'];
            $_id=$_POST['id'];
            $editID=new MongoDB\BSON\ObjectId($_id);
            $result=$tasks->updateOne([
                '_id'=>$editID,
            ],['$set'=>[
              'taskName'=>$taskName,
                'taskDescription'=>$taskDescription
            ]]);
            if($result->getModifiedCount() >0){
                echo json_encode(['message'=>'done']);
            }else{
                echo json_encode(['message'=>'internalServerError']);
            }
        }
        else{
        echo json_encode(['message'=>'invalidAction']);
      }



}  elseif ($_SERVER["REQUEST_METHOD"] == "GET"){

    if($_GET['action']=='getTasks'){
        $id=$_SESSION['id'];
        $result=$tasks->find([
            'userid'=>new MongoDB\BSON\ObjectId($id),
        ]);
        $finalTasks=iterator_to_array($result);
        echo (json_encode($finalTasks));
    }elseif ($_GET['action']=='deleteTask'){
        $id=$_GET['id'];
        $result=$tasks->deleteOne([
           '_id'=>new MongoDB\BSON\ObjectId($id),
        ]);
        if($result->getDeletedCount() > 0){
            echo json_encode(['message'=>'done']);
        }else{
            echo json_encode(['message'=>'notDeleted']);
        }

    }elseif ($_GET['action']=='detailsBeforeEditTask'){
        $id=$_GET['id'];
        $result=$tasks->findOne([
            '_id'=>new MongoDB\BSON\ObjectId($id),
        ]);
        echo json_encode($result);
    }

}

else{
    echo json_encode(['message'=>'invalidRequest']);
}

