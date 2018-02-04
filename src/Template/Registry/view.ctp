<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registry $registry
 */
?>
<?php if($admin): ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Entry'), ['action' => 'edit', $registry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Entry'), ['action' => 'delete', $registry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Entries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Entry'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<?php endif;?>
<div class="registry view large-9 medium-8 columns content">
    <h3><?= h($registry->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $registry->has('user') ? $this->Html->link($registry->user->id, ['controller' => 'Users', 'action' => 'view', $registry->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entry Key') ?></th>
            <td><?= h($registry->entry_key) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($registry->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($registry->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($registry->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $registry->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Entry Value') ?></h4>
        <?= $this->Text->autoParagraph(h($registry->entry_value)); ?>
    </div>
</div>
