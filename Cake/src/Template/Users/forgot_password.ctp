<div class="row">
    <div class="col-md-4 offset-md-4">
        <?php echo $this->Flash->render()?>
        <div class ="card">
            <h3 class="card-header"> Forgot Password<h3>
            <div class="card-body">
                <?= $this->Form->create() ?>
                <div>
                <?= $this->Form->control('email') ?>
                </div>
                <?= $this->Form->button('Reset Password') ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>