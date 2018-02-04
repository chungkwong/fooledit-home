<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

?>
    
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($title)?$title . '|' . __('Fooledit'):__('Fooledit - The editor for fool') ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('common.css') ?>
    <!--<?= $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css') ?>
    <?= $this->Html->script('//code.jquery.com/jquery-1.10.2.js') ?>
    <?= $this->Html->script('//code.jquery.com/ui/1.11.4/jquery-ui.js') ?>
    <?= $this->Html->script('default.js') ?>-->
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="home">

    <?= $this->element('header') ?>
    <div class="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    </div>
    <?= $this->element('footer',['copyright_from'=>'2017','copyright_to'=>date('Y',time())]) ?>
</body>
</html>

