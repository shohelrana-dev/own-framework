<?php
/**
 * @var array $todos
 */
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3>All Todos</h3>
                    <a class="btn btn-light" href="<?php echo url( '/todos/create' ) ?>">Create Todo</a>
                </div>
                
				<?php if ( session_has( 'success_msg' ) ): ?>
                    <div class="alert alert-success"><?php echo session( 'success_msg' ); ?></div>
				<?php endif; ?>

                <div class="card-body">
					<?php if ( count( $todos ) ): ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ( $todos as $todo ): ?>
                                <tr>
                                    <td><?php echo $todo->id ?></td>
                                    <td><?php echo $todo->title ?></td>
                                    <td><?php echo $todo->content ?></td>
                                    <td>
                                        <a href="<?php echo url( '/todos/edit/' . $todo->id ); ?>"
                                           class="btn btn-primary btn-sm">Edit</a>
                                        <span>||</span>
                                        <a href="<?php echo url( '/todos/delete/' . $todo->id ); ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you confirm to delete?')"
                                        >
                                            Delete
                                        </a>
                                    </td>
                                </tr>
							<?php endforeach ?>
                            </tbody>
                        </table>
					<?php else: ?>
                        <h3 class="text-center">Todos Data is Empty</h3>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>