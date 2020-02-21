<div class="index large-4 medium-4 large0offset-4 medium-offset-4 columns">
    <div class="panel">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <h2 class="text-center">Login</h2>
        <fieldset>
            <legend><?= __('Please enter your username and password') ?></legend>
            <?= $this->Form->control('username') ?>
            <?= $this->Form->control('password') ?>
        </fieldset>
        <?= $this->Form->button(__('Login')); ?>
        <?= $this->Html->link('Forgot Password', ['action' => 'forgotPassword']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>