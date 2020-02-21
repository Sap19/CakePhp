
<h1 class="text-center">Blog articles</h1>
<nav class="actions large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link('Add Article', ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="categories index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('category')?></th>
                <th><?= $this->Paginator->sort('author')?></th>
                <th class="actions"><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                
            </tr>
        </thead>
    <?php foreach ($articles as $article): ?>
    <tr>
        
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
            
        </td>
        <td>
            <?= $article->category->name ?>
        </td>
        <td>
            <?= $article->user->username ?>
        </td>
        <td>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $article->id],
                ['confirm' => 'Are you sure T_T']
            ) ?>
            <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
        </td>
        <td>
            <?= $article->created->format('M-d-Y ') ?>
        </td>
        <td>
            <?= $article->modified->format('M-d-Y' ) ?>
        </td>
        
    </tr>
        <?php endforeach; ?>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
 </div>