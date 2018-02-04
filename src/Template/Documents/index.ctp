<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document[]|\Cake\Collection\CollectionInterface $documents
 */
?>
<?php if($admin): ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<?php endif;?>
<div class="documents">
    <nav class="table-of-contents">
        <?php
            function genNav($path,$from,$curr,$Documents,$encoder){
                if($from>=sizeof($path)){
                    return;
                }
                echo '<ul>';
                if($from==-1){
                    $children=$Documents->find()->where('parent_id IS NULL');
                }else{
                    $crumb=$path[$from];
                    $children=$Documents->find('children', ['for' => $crumb->id, 'direct' => true]);
                }
                foreach ($children as $child){
                    echo "<li>";
                    $link=$Documents->find('path', ['for' => $child->id])->all()->
                               map(function($doc){return $doc->slug;})->
                               reduce(function($a,$b){return "$a/$b";},'');
                    if($curr['id']==$child->id){
                        echo $encoder->link($child->title,$link,['class'=>'main-link']);
                    }else{
                        echo $encoder->link($child->title,$link.'/');
                    }
                    if($from+1<sizeof($path) && $path[$from+1]->id==$child->id){
                        genNav($path,$from+1,$curr,$Documents,$encoder);
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
            $crumbs = $root==null?[]:$Documents->find('path', ['for' => $root['id']])->toArray();
            genNav($crumbs,-1,$root,$Documents,$this->Html);
        ?>
    </nav>
    <article class="content">
        <h2><?= __('Table of contents') ?></h2>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('slug') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?= $this->Number->format($document->id) ?></td>
                    <td><?= h($document->title) ?></td>
                    <td><?= $document->has('parent_document') ? $this->Html->link($document->parent_document->title, ['controller' => 'Documents', 'action' => 'view', $document->parent_document->id]) : '' ?></td>
                    <td><?= $document->has('user') ? $this->Html->link($document->user->username, ['controller' => 'Users', 'action' => 'view', $document->user->id]) : '' ?></td>
                    <td><?= h($document->slug) ?></td>
                    <td><?= h($document->published) ?></td>
                    <td><?= h($document->created) ?></td>
                    <td><?= h($document->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'),  
                                    $Documents->find('path', ['for' => $document->id])->all()->
                                    map(function($doc){return $doc->slug;})->
                                    reduce(function($a,$b){return "$a/$b";},'')) ?>
                        <?php if($admin): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                        <?= $this->Html->link(__('Translate'), ['action' => 'translate', $document->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </article>
</div>
