
<h1 class="text-center"> Add Artcile test </h1>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Article'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="index large-4 medium-4 large0offset-4 medium-offset-4">
        <?= $this->Form->create($article); ?>
        <?= $this->Form->control('category_id'); ?>
        <?= $this->Form->control('title'); ?>
        <?= $this->Form->control('body' , ['rows' =>3]); ?>
        <?= $this->Form->button(__('Save Article')); ?>
        <?= $this->Form->end(); ?>
</div>