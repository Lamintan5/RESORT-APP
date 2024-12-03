<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <title>Auth</title>
    <style>
        body {
          font-family: "Roboto", sans-serif;
          background-color: #f8fafb;
        }

        .form-container {
          display: none; 
        }

        .form-container.active {
          display: block; 
        }

        .form-select-control {
            background-color: transparent;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }

        .content {
          padding: 7rem 0;
        }

        .social-login a {
          margin-right: 10px;
        }

        .forgot-pass {
          cursor: pointer;
        }

        .title{
            font-size: 30px;
            font-weight: 800;
        }
        .content p {
            color: #4d4d4d;
            font-size: 14px;
        }
    </style>
  </head>
  <body>
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-6 order-md-2">
            <img src="images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
          </div>
          <div class="col-md-6 contents">
            <div class="row justify-content-center">
              <div class="col-md-8">
              <h3 class="title"id="form-title">Sign In</h3>
              <p class="mb-4">Welcome back! Please login to your account.</p>

                <div id="signin-form" class="form-container active">
                  <div class="mb-4">
                  </div>
                  <form action="process.php" method="post">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group first">
                      <label for="email_or_username">Email</label>
                      <input type="text" name="email" class="form-control" id="login-email" required>
                    </div>
                    <div class="form-group last mb-4">
                      <label for="password">Password</label>
                      <input type="password" name="password" class="form-control" id="login-password" required>
                    </div>
                    <div class="d-flex mb-5 align-items-center">
                      <label class="control control--checkbox mb-0">
                        <span class="caption">Remember me</span>
                        <input type="checkbox" checked="checked">
                        <div class="control__indicator"></div>
                      </label>
                      <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                    </div>
                    
                   
                  </form>

                  
                </div>

                <div id="register-form" class="form-container">
                    <form action="register.php" method="post">
                      <input type="hidden" name="action" value="register">
                      <div class="form-group first">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="reg-username" name="username" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="reg-email" name="email" required>  
                      </div>
                      <label for="role">Select Role</label>
                      <div class="form-group">
                        <select class="form-control" id="role" name="role" required>
                          <option value="admin">Admin</option>
                          <option value="customer">Customer</option>
                        </select>
                      </div>
                      <div class="form-group last mb-4">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="reg-password" name="password" required>
                      </div>
                    </form>
                </div>
                <input type="button" value="Log In" class="btn text-white btn-block btn-primary"  id="form-button">
                <span class="ml-auto"><a href="#" id="toggle-form" class="forgot-pass">Register Account</a></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/main.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

		const toggleForm = document.getElementById('toggle-form');
		const formTitle = document.getElementById('form-title');
		const loginFields = document.getElementById('signin-form');
		const registerFields = document.getElementById('register-form');
		const formButton = document.getElementById('form-button');

		toggleForm.addEventListener('click', (e) => {
			e.preventDefault();

			if (loginFields.style.display === 'none') {
				loginFields.style.display = 'block';
				registerFields.style.display = 'none';
				formTitle.textContent = 'Login';
				formButton.textContent = 'Login';
				toggleForm.innerHTML = 'Create your Account <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>';
			} else {
				loginFields.style.display = 'none';
				registerFields.style.display = 'block';
				formTitle.textContent = 'Register';
				formButton.textContent = 'Register';
				toggleForm.innerHTML = 'Already have an account? <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>';
			}
		});

		formButton.addEventListener('click', async () => {
			const isRegister = registerFields.style.display === 'block';
			const url = isRegister ? 'register.php' : 'login.php';
			const data = isRegister
				? {
					username: document.getElementById('reg-username').value,
					email: document.getElementById('reg-email').value,
					password: document.getElementById('reg-password').value,
					role: document.getElementById('role').value
				}
				: {
					email: document.getElementById('login-email').value,
					password: document.getElementById('login-password').value,
				};

			const response = await fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(data),
			});

			const result = await response.json();
			if (result.success) {
            alert(result.message);
            window.location.href = "index.php";
        } else {
            alert(result.message);
        }
		});
	</script>

  </body>
</html>
