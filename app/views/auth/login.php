<?php
/**
 * @var Core\Support\ErrorBag $errors
 */
?>
<header>
    <div class="container" style="max-width: 700px">
        <h1 class="text-center my-5">Login</h1>
    </div>
</header>
<section>
    <div class="container" style="max-width: 700px">
        <div class="d-flex justify-content-between my-3">
            <h5>Please login bellow</h5>
            <a class="btn btn-primary" href="<?php echo url( '/auth/signup' ); ?>">Signup</a>
        </div>

		<?php if ( session_has( 'success_msg' ) ): ?>
            <div class="alert alert-success"><?php echo session( 'success_msg' ); ?></div>
		<?php endif; ?>
		<?php if ( session_has( 'error_msg' ) ): ?>
            <div class="alert alert-danger"><?php echo session( 'error_msg' ); ?></div>
		<?php endif; ?>

        <form action="" method="post">
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
                    <p class="error text-danger"><?php echo $errors->get( 'password' ); ?></p>
				<?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</section>