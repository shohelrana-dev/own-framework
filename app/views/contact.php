<?php
/**
 * @var Core\Support\ErrorBag $errors
 */
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <header>
                    <div class="container">
                        <h1 class="text-center my-5">Contact Us</h1>
                    </div>
                </header>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" class="form-control" id="subject">
						<?php if ( $errors->has( 'subject' ) ): ?>
                            <p class="error text-danger"><?php echo $errors->get( 'subject' ) ?></p>
						<?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="text" name="email" class="form-control" id="subject">
						<?php if ( $errors->has( 'email' ) ): ?>
                            <p class="error text-danger"><?php echo $errors->get( 'email' ) ?></p>
						<?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea type="text" name="message" class="form-control" id="message"></textarea>
						<?php if ( $errors->has( 'message' ) ): ?>
                            <p class="error text-danger"><?php echo $errors->get( 'message' ) ?></p>
						<?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
