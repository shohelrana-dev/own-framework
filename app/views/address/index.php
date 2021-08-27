<?php
/**
 * @var array $addresses
 */
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3>All Addresses</h3>
                    <a class="btn btn-light" href="<?php echo url( '/address/create' ) ?>">Create Address</a>
                </div>
                
				<?php if ( session_has( 'success_msg' ) ): ?>
                    <div class="alert alert-success"><?php echo session( 'success_msg' ); ?></div>
				<?php endif; ?>

                <div class="card-body">
					<?php if ( count( $addresses ) ): ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ( $addresses as $address ): ?>
                                <tr>
                                    <th><?php echo $address->id ?></th>
                                    <th><?php echo $address->name ?></th>
                                    <th><?php echo $address->email ?></th>
                                    <th><?php echo $address->address ?></th>
                                    <th>
                                        <a href="<?php echo url( '/address/edit/' . $address->id ); ?>"
                                           class="btn btn-primary btn-sm">Edit</a>
                                        <span>||</span>
                                        <a href="<?php echo url( '/address/delete/' . $address->id ); ?>"
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </th>
                                </tr>
							<?php endforeach ?>
                            </thead>
                        </table>
					<?php else: ?>
                        <h3 class="text-center">Addresses Data is Empty</h3>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>