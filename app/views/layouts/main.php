<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Own php framework</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('/css/app.css'); ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?php echo url('/'); ?>">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('/'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('/contact'); ?>">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
				<?php if ( isAuth() ): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/auth/logout'); ?>">(<?php echo session( 'logged_in_user_name' ) ?>) Logout</a>
                    </li>
				<?php endif; ?>
				<?php if ( isGuest() ): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/auth/login'); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo url('/auth/signup'); ?>">Signup</a>
                    </li>
				<?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
    {{content}}
</main>

</body>
</html>

