<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<?php if($admin): ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Documents'), ['controller' => 'Documents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Document'), ['controller' => 'Documents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<?php endif; ?>
<div class="documents">
    <nav class="table-of-contents">
        <?php
            function genNav($path,$from,$curr,$documents,$encoder){
                if($from>=sizeof($path)){
                    return;
                }
                echo '<ul>';
                if($from==-1){
                    $children=$documents->find()->where('parent_id IS NULL');
                }else{
                    $crumb=$path[$from];
                    $children=$documents->find('children', ['for' => $crumb->id, 'direct' => true]);
                }
                foreach ($children as $child){
                    echo "<li>";
                    if($curr->id==$child->id){
                        echo $child->title;
                    }else{
                        echo $encoder->link($child->title,
                                $documents->find('path', ['for' => $child->id])->all()->
                                map(function($doc){return $doc->slug;})->
                                reduce(function($a,$b){return "$a/$b";},''));
                    }
                    if($from+1<sizeof($path) && $path[$from+1]->id==$child->id){
                        genNav($path,$from+1,$curr,$documents,$encoder);
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
            $crumbs = $documents->find('path', ['for' => $document->id])->toArray();
            genNav($crumbs,-1,$document,$documents,$this->Html);
        ?>
    </nav>
    <article class="article">
        <h2><?= h($document->title) ?></h2>
        <div class="created">
        <?= $document->has('user') ? $this->Html->link($document->user->username, ['controller' => 'Users', 'action' => 'view', $document->user->id]) : '' ?>
        <?= $document->published ? __('Published') : __('Submitted'); ?>
        <?= h($document->created) ?>
        </div>
        <div class="body">
            <?= $document->body; ?><!-- FIXME: Not safe -->
        </div>
        <div class="modified">
        <?= __('Modified') ?><?= h($document->modified) ?>
        </div>
    </article>
</div>