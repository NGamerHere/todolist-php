<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="static/icons8-login-100.png">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .register-link {
            color: #1877f2;
            text-decoration: none;
        }
        .register-link:hover {
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
                <p style="visibility: hidden" id="usernameError"></p>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" id="username" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="mb-3">
                <p style="visibility: hidden" id="passwordError"></p>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="button" onclick="submitHandle()" class="btn btn-primary">Login</button>
            </div>
            <p class="text-center mt-3">
                <small>Don't have an account? <a href="registration.php" class="register-link">Register here</a></small>
            </p>
        </form>
    </div>
</div>

<script>
    function submitHandle() {
        const username=document.getElementById('username');
        const password=document.getElementById('password');
        if(username.value === ''){
            alert('email is empty');
            return ;
        }else if(password.value === ''){
            alert('password is empty');
            return ;
        }
        const formdata = new FormData();
        formdata.append('username',username.value);
        formdata.append('password', password.value);
        formdata.append('action', 'login');

        axios.post('backend.php', formdata)
            .then((response) => {
                console.log(response.data);
                if (response.data.message === 'done') {
                    window.location.href = 'dashboard.php';
                } else if (response.data.message === 'passwordWrong') {
                    document.getElementById('password').style.borderColor='red';
                    document.getElementById('passwordError').style.visibility='visible';
                    document.getElementById('passwordError').style.color='red';
                    document.getElementById('passwordError').innerHTML=' Incorrect password';
                } else if (response.data.message === 'usernameNotFound') {
                    document.getElementById('username').style.borderColor='red';
                    document.getElementById('usernameError').style.visibility='visible';
                    document.getElementById('usernameError').style.color='red';
                    document.getElementById('usernameError').innerHTML='username is not found';
                }
            })
            .catch(function (e) {
                console.error('Error in login: ' + e);
                alert('An error occurred. Please try again later.');
            });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>