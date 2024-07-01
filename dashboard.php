<?php
 session_start();

 if(!isset($_SESSION['name'])){
     echo "<script>window.location.href='login.php'</script>";
 }
?>

<!doctype html>
<html lang="en">
<head>
    <style>
        .taskBox{
            height: 200px;
            width: 250px;
            margin: 10px;
            padding: 10px;
            background-color: #E7F0DC;
            box-shadow: 2px 2px 3px gray;
        }

    </style>
    <style>
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="static/icons8-todo-list-96.png">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <title>dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Task Manager</a>
        <div>
            <button type="button" id="addTaskbtn" class="btn btn-primary me-2" onclick="addTasKprop()" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="fas fa-plus"></i> Add Task
            </button>
            <a href="logout.php" class="btn btn-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center mb-4">Welcome, <?php echo $_SESSION['name']; ?>!</h2>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <input placeholder="Task Name" id="taskName" class="form-control" />
                    </div>
                    <input id="mode" type="hidden" />
                    <input id="editID" type="hidden" />
                    <div class="mb-3">
                        <textarea placeholder="Task Description" id="taskDescription" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="datepickerStart" class="form-label">Start Date:</label>
                        <input type="text" id="datepickerStart" class="form-control datepicker">
                    </div>
                    <div class="mb-3">
                        <label for="datepickerEnd" class="form-label">End Date:</label>
                        <input type="text" id="datepickerEnd" class="form-control datepicker">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="probtn" onclick="addTask()">Add Task</button>
            </div>
        </div>
    </div>
</div>


<div class="container mt-4">
    <div id="tasksDisplay" class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Tasks will be dynamically added here -->
    </div>
</div>


<script>
    $( function() {
        $( "#datepicker" ).datepicker();
    } );
    function addTasKprop(){
        const modalHeading=document.getElementById('addTaskModalLabel');
        const btn=document.getElementById('probtn');
          modalHeading.innerText='add new task';
          btn.innerText='save'
    }
    function addTask(){
        const taskName=document.getElementById('taskName');
        const taskDescription=document.getElementById('taskDescription');
        const mode=document.getElementById('mode');
        const editID=document.getElementById('editID');
        if(taskName.value === ''){
            taskName.style.borderColor='red';
            return;
        }
        if(taskDescription.value === ''){
            taskDescription.style.borderColor='red';
            return;
        }
         if(mode.value === 'edit') {
             const formData=new FormData();
             formData.append('taskName',taskName.value)
             formData.append('taskDescription',taskDescription.value)
             formData.append('action','editTask');
             formData.append('id',editID.value);
             axios.post('backend.php',formData).then((response)=>{
                 console.log(response.data);
                 if(response.data.message === 'done'){
                     showTasks();
                     document.getElementById('close').click();
                     taskName.value='';
                     taskDescription.value='';
                     editID.value='';
                     mode.value='';
                 }else {
                     document.getElementById('close').click();
                     alert('something went wrong');
                 }
             }).catch((e)=>{
                 console.error( "error in adding the task + ",e)
             })

    }else{
             const formData=new FormData();
             formData.append('taskName',taskName.value)
             formData.append('taskDescription',taskDescription.value)
             formData.append('action','addNewTask');
             axios.post('backend.php',formData).then((response)=>{
                 console.log(response.data);
                 if(response.data.message === 'done'){
                     showTasks();
                     document.getElementById('close').click();
                     taskName.value='';
                     taskDescription.value='';
                 }else {
                     document.getElementById('close').click();
                     alert('something went wrong');
                 }
             }).catch((e)=>{
                 console.error( "error in adding the task + ",e)
             })
         }

    }
    function showTasks(){
        const mainTasks = document.getElementById('tasksDisplay');
        axios.get('backend.php?action=getTasks').then((response) => {
            console.log(response.data);
            let str = '';
            response.data.forEach((items, index) => {
                str += `
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${items['taskName']}</h5>
                        <p class="card-text">${items['taskDescription']}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <button class="btn btn-sm btn-outline-danger me-2" onclick="deleteTask('${items['_id']['$oid']}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="editTask('${items['_id']['$oid']}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                </div>
            </div>`;
            });
            mainTasks.innerHTML = str;
        }).catch((e) => {
            console.error('error in getting the tasks '+e);
        });
    }
    function deleteTask(id){
        console.log(id);
        axios.get('backend.php?action=deleteTask&id='+id).then((response)=>{
            console.log(response.data);
            if(response.data.message === 'done'){
                showTasks();
            }else {
                alert('not been deleted');
            }
        }).catch((e)=>{
            console.error('could not been deleted '+e);

        })
    }
    function editTask(id){
        const probtn=document.getElementById('probtn');
        const modalTitle=document.getElementById('addTaskModalLabel');
        axios.get('backend.php?action=detailsBeforeEditTask&id='+id).then((response)=>{
            console.log(response.data);
            const taskName=document.getElementById('taskName');
            const taskDescription=document.getElementById('taskDescription');
             taskName.value=response.data.taskName;
             taskDescription.value=response.data.taskDescription;
            document.getElementById('addTaskbtn').click();
            document.getElementById('mode').value='edit';
            document.getElementById('editID').value=id;
            probtn.innerHTML='edit';
            modalTitle.innerHTML='edit the task'
        }).catch((e)=>{
            console.error('could not been edited '+e);
        })
    }

    showTasks();
</script>


</body>
</html>