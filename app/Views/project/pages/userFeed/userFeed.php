<?php 
echo $this->extend('project/layout');

echo $this->section('content');
?>
<div class="row">
    <div class="col-2">
        <h1><?php if(!empty($uinfo['u_name'])){ echo $uinfo['u_name']; }?> RSS hírei</h1>
        
        <div class="rss-add-box">
            <form method="post" action="<?php echo base_url('userfeed/add');?>" >
                <div class="form-group">
                    <label for="rss_inp" ><h6>RSS cím hozzáadása</h6></label>
                    <input class="form-control" id="rss_inp" type="text" name="rss_url" placeholder="pl. https://valami.hu/hirfolyam/hirek/rss.xml"><br>
                    <button type="submit" class="btn btn-outline-primary" >Hozzáad</button>
                </div>
                <?php
                if(!empty(session()->getFlashdata('formError'))){ echo session()->getFlashdata('formError'); }
                ?>
            </form>
        </div>
        <div class="rss-menu">
            <h6>RSS Link Listád</h6>
            <?php 
                if( !empty($rss_feeds))
                {
                    ?>
                    <ul class="list-group rss-menu-list">
                        <?php
                    foreach( $rss_feeds as $rss )
                    {
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php
                                    if(!empty($rss['name']))
                                        { echo $rss['name']; }
                                    else
                                        { echo 'link_'.$rss['id']; }
                                ?>
                                <a class="badge badge-secondary" href="<?php echo base_url('userfeed/delete/'.$rss['id']);?>" >Töröl</a>
                                <div class="clear"></div>
                            </li>
                        <?php
                    }
                    ?>
                    </ul>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="col-10">
        <div class="row">
            
            <?php 
            $feed_size = !empty($rss_feeds) ? count($rss_feeds) : 1;
            $feed_datas_size = !empty($rss_feed_datas) ? count($rss_feed_datas) : -1;
            if( $feed_size == $feed_datas_size )
            {
            ?>
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php
                        if( !empty($rss_feeds))
                        {
                            foreach( $rss_feeds as $rkey => $rss )
                            {
                                $active = $rkey == 0 ? 'active': '';
                                if(!empty($rss['name']))
                                {
                                    ?>
                                    <a class="nav-link <?php echo $active;?>" id="v-<?php echo $feed_size;?>-tab" data-toggle="pill" href="#v-<?php echo $feed_size; ?>" role="tab" aria-controls="v-<?php echo $feed_size; ?>" aria-selected="true">
                                        <?php echo $rss['name'];?>
                                    </a>
                                    <?php
                                }
                                $feed_size--;
                            }
                        }
                    ?>
                    </div>
                </div>
                <div class="col-9">
                                <?php
                            if( !empty($rss_feed_datas) )
                            {
                                ?>
                                <div class="tab-content" id="v-pills-tabContent">
                                    <?php
                                foreach($rss_feed_datas as $rss_domain => $rss_data_arrays)
                                {
                                    $activeTab = $feed_datas_size == count($rss_feed_datas) ? 'show active' : '';
                                    ?>
                                        <div class="tab-pane fade <?php echo $activeTab; ?>" id="v-<?php echo $feed_datas_size; ?>" role="tabpanel" aria-labelledby="v-<?php echo $feed_datas_size;?>-tab">
                                            <div class="row">
                                        <?php
                                    foreach($rss_data_arrays as $rss_date => $rss_data_by_date)
                                    {
                                    ?>
                                                <div class="col-4">
                                                  <div class="card">
                                                    <!--<img src="..." class="card-img-top" alt="...">-->
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php  if(!empty($rss_data_by_date['title'])){echo $rss_data_by_date['title'];}?></h5>
                                                      <p class="card-text"><?php  if(!empty($rss_data_by_date['description'])){echo $rss_data_by_date['description'];}?></p>
                                                      <a href="<?php  if(!empty($rss_data_by_date['link'])){echo $rss_data_by_date['link'];}?>" target="_blank" class="btn btn-primary">Tovább...</a>
                                                    </div>
                                                    <div class="card-footer">
                                                      <small class="text-muted"><?php if(!empty($rss_data_by_date['pubDate'])){echo $rss_data_by_date['pubDate'];}?></small>
                                                    </div>
                                                  </div>
                                                    
                                                </div>
                                                
                                        <?php
                                    }
                                    ?>
                                            </div>
                                        </div>
                                    <?php
                                    $feed_datas_size--;
                                }
                                ?>

                                </div>
                                    <?php
                            }
                        ?>
                </div>
                    
            <?php
            }
            ?>
        </div>
    </div>
</div>


<?php 
echo $this->endSection();
?>