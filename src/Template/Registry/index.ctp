<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registry[]|\Cake\Collection\CollectionInterface $registry
 */
?>
<?php if($admin): ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Entry'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<?php endif;?>
<div class="registry index large-9 medium-8 columns content">
    <h3><?= __('Registry') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entry_key') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entry_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registry as $registry): ?>
            <tr>
                <td><?= $this->Number->format($registry->id) ?></td>
                <td><?= $registry->has('user') ? $this->Html->link($registry->user->id, ['controller' => 'Users', 'action' => 'view', $registry->user->id]) : '' ?></td>
                <td><?= h($registry->entry_key) ?></td>
                <td><?= h($registry->entry_value) ?></td>
                <td><?= h($registry->published) ?></td>
                <td><?= h($registry->created) ?></td>
                <td><?= h($registry->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $registry->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registry->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registry->id)]) ?>
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
</div>
