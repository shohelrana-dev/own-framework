<?php
/**
 * @var Core\Support\ErrorBag $errors
 * @var object $address
 * @var int $id
 */
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3>Edit Address Info</h3>
                    <a class="btn btn-light" href="<?php echo url( '/' ) ?>">Back To Address List</a>
                </div>
                <div class="card-body">
					<?php if ( session_has( 'error_msg' ) ): ?>
                        <div class="alert alert-success"><?php echo session( 'error_msg' ); ?></div>
					<?php endif; ?>

                    <form action="<?php echo url( '/address/edit/' . $id ) ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="<?php echo $address->name ?>" class="form-control"
                                   id="name">
							<?php if ( $errors->has( 'name' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'name' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" name="email" value="<?php echo $address->email ?>" class="form-control"
                                   id="email">
                        </div>
                        <div class="form-group">
                            <label for="email">Address</label>
                            <input type="text" name="address" value="<?php echo $address->address ?>"
                                   class="form-control"
                                   id="address">
							<?php if ( $errors->has( 'address' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'address' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>