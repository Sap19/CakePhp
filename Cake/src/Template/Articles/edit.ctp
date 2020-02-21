<h1 class="text-center">Edit Article</h1>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Article'), ['action' => 'index']) ?></li>
    </ul>
</nav>

<div class="index large-4 medium-4 large0offset-4 medium-offset-4">
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('body');
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>
</div>