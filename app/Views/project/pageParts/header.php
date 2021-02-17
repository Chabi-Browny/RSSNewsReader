<header class="col">
    <div class="row">
        <div class="col-1 logo">
            <a href="<?php echo BASEURL;?>" target="_self">
                <img alt="rss_logo" src="<?php echo BASEURL;?>/assets/images/Feed-icon.svg">
            </a>
        </div>
        <div class="col page-name">
            <h1>RSS Reader</h1>
        </div>
        <div class="col-8">
            <nav class=" menu">
                <a href="<?php echo BASEURL;?>" >Főoldal</a>
                <?php 
                $usession = session('uinfo');
                if(isset($usession))
                {
                    ?>
                    <a href="<?php echo base_url('userfeed');?>" >RSSfeed</a>
                    <a href="<?php echo base_url('logout');?>" >Kilépés</a>
                    <?php
                }
                ?>
            </nav>
        </div>
        <div class="clear"></div>
    </div>
</header>