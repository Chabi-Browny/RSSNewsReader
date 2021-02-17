<?php 
echo $this->extend('project/layout');

echo $this->section('content');
?>
    <h1>Üdvözöllek az RSS hírolvasóban!</h1>
        <!-- belépő/regisztráló form -->
    <?php 
        $usession = session('uinfo');
        if(!isset($usession))
        {
            ?>
            <h2>Lépj be!</h2>
            <div class="card">
                <div class="card-body">
                    <div class="msg-succ"></div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="login-tab">
                            <form id="log" method="post" action="" >
                                <div class="form-group" id="llogname">
                                    <label for="namefield">Felhasználó név:</label>
                                    <input type="text" name="logname" id="namefield" class="form-control" placeholder="Pl.: user123" >
                                </div>
                                <div class="form-group" id="llogpass">
                                    <label for="pwfield">Jelszó:</label>
                                    <input type="text" name="logpass" id="pwfield" class="form-control" placeholder="Pl.: 123U!">
                                </div>
                                <div class="msg-fail"></div>
                                <button type="submit" class="btn btn-outline-primary" onclick="logg()">Belépés</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="reg-tab">
                            <form id="reg" method="post" action="" >
                                <div class="form-group" id="gregname">
                                    <label for="namefield">Felhasználó név:</label>
                                    <input type="text" name="regname" id="namefield" class="form-control" placeholder="Pl.: user123" >
                                </div>
                                <div class="form-group" id="gregpass">
                                    <label for="pwfield">Jelszó:</label>
                                    <input type="text" name="regpass" id="pwfield" class="form-control" placeholder="Pl.: 123U!">
                                </div>
                                <button type="submit" class="btn btn-outline-secondary" onclick="regist()">Mentés</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#nav-login" role="tab"  aria-controls="login" aria-selected="true">Belépés</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="reg-tab" data-toggle="tab" href="#nav-reg" role="tab" aria-controls="reg" aria-selected="false">Regisztráció</a>
                        </li>
                    </ul>
                </div>
            </div>
                <?php
        }
    ?>
        
                
<?php 
echo $this->endSection();
?>