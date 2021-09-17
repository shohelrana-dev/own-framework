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
                    <h3>Create Todo</h3>
                    <a class="btn btn-light"
                       href="<?php echo url( '/' ) ?>">Back To Todo List</a>
                </div>
                <div class="card-body">
                    <form action="<?php echo url( '/todos/create' ) ?>" method="POST">

						<?php if ( session_has( 'error_msg' ) ): ?>
                            <div class="alert alert-success"><?php echo session( 'error_msg' ); ?></div>
						<?php endif; ?>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="<?php echo old( 'title' ); ?>" class="form-control"
                                   id="title">
							<?php if ( $errors->has( 'title' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'title' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content"
                                      class="form-control"
                                      id="content"><?php echo old( 'content' ); ?></textarea>
							<?php if ( $errors->has( 'content' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'content' ) ?></p>
							<?php endif; ?>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Save Todo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>