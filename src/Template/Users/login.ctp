<h1><?= __('Login') ?></h1>

<h2><?= __('Fool ID') ?></h2>
<?= $this->Form->create() ?>
<?= $this->Form->control('username',['autofocus']) ?>
<?= $this->Form->control('access_token',['type'=>'password']) ?>
<?= $this->Form->button(__('Login')) ?>
<?= $this->Form->end() ?>

<h2><?= __('Third-party ID') ?></h2>
<a href="https://github.com/login/oauth/authorize?client_id=1411d4246b7596e536df">
    <?= $this->Html->image('GitHub-Mark-32px.png',['alt'=>__('GitHub')]) ?>
</a>
