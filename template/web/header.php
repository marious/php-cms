<header>
    <div class="container">

        <div class="logo">
            <h1><a href="#">BD <span>Business Design<span></a></h1>
        </div>


        <div class="social">
            <p>Join the conversation</p>
            <ul>
                <li><a href="#"><i class="fa fa-facebook-square facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter-square twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus-square google"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube-square youtube"></i></a></li>
            </ul>
        </div><!-- end ./social -->
        <?php if (User::isLoggedIn()){ ?>
            <h4 class="welcome-message">Welcome <?php echo User::theUser()->username; ?>
                <a href="./logout">Logout</a> or, <a href="./admin">Go To CPanel</a>
            </h4>

        <?php }  else { ?>
            <h4 class="welcome-message">Welcome Guest, <a href="./login">Login</a>
                <?php if (User::theUser()->privilege == 1){ ?>or <a href="./register">Register</a></h4> <?php } ?>
        </h4>


        <?php } // end else  ?>

        <?php include WEB_TEMPLATE_PATH . 'nav.php'; ?>

    </div><!-- end ./container -->
</header>
<div class="container">