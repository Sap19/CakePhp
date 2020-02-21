
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link('List Article', ['action' => 'index']) ?></li>
    </ul>
</nav>

<h1 class="text-center"><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p class="text-right"><smal>Author: <?= h($article->user->username) ?></small></p>
<p class="text-right"><smal>Created: <?= $article->created->format('M-d-Y') ?></small></p>
