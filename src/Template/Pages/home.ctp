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
echo $this->Html->css('home.css');
?>
<div class="notice">
    <h1><?= __('Coming soon') ?></h1>	
    <div id="notice"><?= __('Public test expected at Q3 of 2018') ?></div>
</div>
<div class="columns">
    <div class="aspect" id="development">
        <h2><?= __('Powerful') ?></h2>
        <ul>
            <li><?= __('Efficient') ?></li>
            <li><?= __('Accurate') ?></li>
            <li><?= __('Integrated') ?></li>
            <li><?= __('Extensible') ?></li>
        </ul>
    </div>
    <div class="aspect" id="friendly">
        <h2><?= __('Friendly') ?></h2>
        <ul>
            <li><?= __('Out-of-the-box') ?></li>
            <li><?= __('Straightforward') ?></li>
            <li><?= __('Reliable') ?></li>
            <li><?= __('Customizable') ?></li>
        </ul>
    </div>
</div>

