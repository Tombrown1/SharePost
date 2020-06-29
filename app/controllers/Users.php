<?php
// Users Controller Class
class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){
        // Check for Post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
              // Process Form
            // Sanitize Post Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Init Data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //  Validate Email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }else{
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email already exist';
                }
            }
            //  Validate name
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter name'; 
            }
            //  Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }elseif(strlen($data['password']) < 6){
                $data['password_err']= 'Password must be at least 6 character';
            }
            // Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please enter confirm password';
            }else{
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Please passwords do not match';
                }
            }

            // make sure errors are empty
            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){

               // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if($this->userModel->register($data)){ 
                    flash('register_success', 'You are registered and can now log in!');
                   redirect('users/login');
                }else{
                    die("Something went wrong");
                }

            }else{
                // Load view with errors
                $this->view('users/register', $data);
            }
        }else{
            // Init Data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            // Load View
            $this->view('users/register', $data);
        }
    }

    public function login(){
        // Check for Post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process Login Form
            // Sanitize login data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];
                // Validate email
            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
                // Validate Password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            // Check for email/user
            if($this->userModel->findUserByEmail($data['email'])){
                // User Found 

            }else{
                // User not Found
                $data['email_err'] = ' No User Found';
            }
            // Make sure error are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
              // Validated
              // Check and set logged in user
              $loggedInUser = $this->userModel->login($data['email'], $data['password']);

              if($loggedInUser){
                  // Create Session
                 $this->createUserSession($loggedInUser);
              }else{
                  $data['password_err'] = 'Password Incorrect';
                  $this->view('users/login', $data);
              }

            }else{
                $this->view('users/login', $data);
            }
        }else{
            // Init Data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            // Load View
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        redirect('posts');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();

        redirect('users/login');
    }
    
}
?>