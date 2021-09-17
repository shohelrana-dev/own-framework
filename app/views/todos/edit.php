<?php
/**
 * @var Core\Support\ErrorBag $errors
 * @var object $todo
 * @var int $id
 */
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3>Edit Todo Info</h3>
                    <a class="btn btn-light" href="<?php echo url( '/' ) ?>">Back To Todo List</a>
                </div>
                <div class="card-body">
					<?php if ( session_has( 'error_msg' ) ): ?>
                        <div class="alert alert-success"><?php echo session( 'error_msg' ); ?></div>
					<?php endif; ?>

                    <form action="<?php echo url( '/todos/edit/' . $id ) ?>" method="POST">

                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" name="title" value="<?php echo $todo->title ?>" class="form-control"
                                   id="title">
							<?php if ( $errors->has( 'title' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'title' ) ?></p>
							<?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content"
                                      class="form-control"
                                      id="content"><?php echo $todo->content ?></textarea>
							<?php if ( $errors->has( 'content' ) ): ?>
                                <p class="error text-danger"><?php echo $errors->get( 'content' ) ?></p>
							<?php endif; ?>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update Todo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>