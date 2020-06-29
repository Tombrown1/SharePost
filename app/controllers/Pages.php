    <?php
        class Pages extends Controller {

            public function __construct(){
               // echo 'Pages Loaded';

            }

            public function index(){
                // Home page redirecting to post using IsloggedIn function from helpers
                if(isLoggedIn()){
                    redirect('posts');
                }

                $data = [
                    'title' => 'Share Posts Platform',
                    'description' => 'Simple Social interactive platform built on Tom PHP MVC Framework'
                ];
                $this->view('pages/index', $data);
            }

            public function about(){
                $data = [
                    'title' => 'About Us',
                    'description' => 'Application to share posts with other users'
                ];
                $this->view('pages/about', $data);                
            }
        }
    ?>