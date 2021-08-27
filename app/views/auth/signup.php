<?php
/**
 * @var Core\Support\ErrorBag $errors
 */
?>
<header>
    <div class="container" style="max-width: 700px">
        <h1 class="text-center my-5">Create an account</h1>
    </div>
</header>
<section>
    <div class="container" style="max-width: 700px">
        <div class="d-flex justify-content-between my-3">
            <h5>Please signup bellow</h5>
            <a class="btn btn-primary" href="/auth/login">Login</a>
        </div>

		<?php if ( session_has( 'error_msg' ) ): ?>
            <div class="alert alert-danger"><?php echo session( 'error_msg' ); ?></div>
		<?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo old( 'name' ); ?>" class="form-control" id="name">
				<?php if ( $errors->has( 'name' ) ): ?>
                    <p class="error text-danger"><?php echo $errors->get( 'name' ) ?></p>
				<?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" name="email" value="<?php echo old( 'email' ); ?>" class="form-control" id="email">
				<?php if ( $errors->has( 'email' ) ): ?>
                    <p class="error text-danger"><?php echo $errors->get( 'email' ) ?></p>
				<?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="password" value="<?php echo old( 'password' ); ?>" class="form-control"
                       id="password">
				<?php if ( $errors->has( 'password' ) ): ?>
                    <p class="error text-danger"><?php echo $errors->get( 'password' ) ?></p>
				<?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="text" name="confirmPassword" value="<?php echo old( 'confirmPassword' ); ?>"
                       class="form-control" id="confirmPassword">
				<?php if ( $errors->has( 'confirmPassword' ) ): ?>
                    <p class="error text-danger"><?php echo $errors->get( 'confirmPassword' ) ?></p>
				<?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Signup</button>

        </form>
    </div>
</section>