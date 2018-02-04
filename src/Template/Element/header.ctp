<header>
        <a href="http://www.fooledit.cc/" class="home">
            <?= $this->Html->image('logo.png',['id'=>'logo']) ?>
            <div class="slogen">
                <div id="title">
                        <?= __('Fooledit') ?>
                </div>
                <div id="description">
                        <?= __('The editor for fool') ?>
                </div>
            </div>
        </a>
        
        <?= $this->Html->link(__('Donate'),'/pages/donate',['class' => 'dropdown']);?>
        <?= $this->Html->link(__('Progress'),'https://github.com/chungkwong/fooledit',['class' => 'dropdown']); ?>
        <div class="right">
        <div class="nowrap">
            <form target="_blank" action="http://zhannei.baidu.com/cse/site" class="searchform">
            <input type="text" name="q" size="20" class="searchbox" placeholder="<?= __('Search') ?>">
            <input type="hidden" name="cc" value="www.fooledit.cc">
            </form>
        </div>
        </div>
</header>