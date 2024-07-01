<html lang="en">
<head>
    <title> login </title>
    <link rel="icon" type="images/png"  href="static/icons8-user-128.png">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-form h2 {
            color: #1877f2;
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }
        .btn-primary {
            background-color: #1877f2;
            border: none;
            border-radius: 20px;
            padding: 0.75rem 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #166fe5;
        }
        .login-link {
            color: #1877f2;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>


<div class="container login-container">
    <div class="login-form">
        <h2 class="text-center mb-4">Login</h2>
        <form>
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="name" class="form-control" placeholder="name">
                </div>
            </div>
            <div class="mb-3">
                <p class="text-center" id="errorEmail">  </p>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="username" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="button" onclick="submitHandle()" class="btn btn-primary">Login</button>
            </div>
            <p class="text-center mt-3">
                <small>already have account? <a href="login.php" class="login-link">login-here</a></small>
            </p>
        </form>
    </div>
</div>
<script>
    function submitHandle(){
        const formdata=new FormData();
        formdata.append('username',document.getElementById('username').value)
        formdata.append('password',document.getElementById('password').value)
        formdata.append('name',document.getElementById('name').value)
        formdata.append('action','registration');
        axios.post('backend.php',formdata).then((response)=>{
            console.log(response.data);
            if(response.data.message === 'done'){ window.location.href='login.php'; }
            else if(response.data.message === 'emailAlreadyThere'){
                console.log('this email is already found in the server')
                document.getElementById('username').style.borderColor='red';
                document.getElementById('errorEmail').style.visibility='visible';
                document.getElementById('errorEmail').style.color='red';
                document.getElementById('errorEmail').innerText='email in already there';

            }
            else { console.log('internal server error') }

        }).catch(function (e){
            console.error('error in login '+e);
        })

    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>