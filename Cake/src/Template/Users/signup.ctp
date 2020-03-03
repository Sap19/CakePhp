


<div class="index large-4 medium-4 large0offset-4 medium-offset-4 columns">
    <div class="panel">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <h2 class="text-center">Sign Up</h2>
        <fieldset>
            
                <?= $this->Form->control('username') ?>
                <?= $this->Form->control('first name') ?>
                <?= $this->Form->control('last name') ?>
                <?= $this->Form->control('email') ?>
                <?= $this->Form->control('password') ?>
                <?= $this->Form->control('role', [
                'options' => [ 'author' => 'Author']
                ]) ?>
        </fieldset>
        <?= $this->Form->button(__('Sign Up')); ?>
        <?= $this->Form->end() ?>
    </div>
</div>