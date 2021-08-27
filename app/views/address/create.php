<?php
/**
 * @var Core\Support\ErrorBag $errors
 */
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3>Create address</h3>
                    <a class="btn btn-light"
                       href="<?php echo url( '/' ) ?>">Back To Address List</a>
                </div>
                <div class="card-body">
                    <form action="<?php echo url( '/address/create' ) ?>" method="POST">
						<?php if ( session_has( 'error_msg' ) ): ?>
                            <div class="alert alert-success"><?php echo session( 'error_msg' ); ?></div>
						<?php endif; ?>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="<?php old( 'name' ) ?>" class="form-control"
                                   id="name">
							<?php if ( $errors->has( 'name' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'name' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" value="<?php old( 'email' ) ?>" class="form-control"
                                   id="email">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="<?php old( 'address' ) ?>" class="form-control"
                                   id="address">
							<?php if ( $errors->has( 'address' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'address' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>