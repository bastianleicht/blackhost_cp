<?php
$currPage = 'customer_Gameserver';
include BASE_PATH.'software/controller/PageController.php';

$items = 0;
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">

                <?php
                $SQL = $db->prepare("SELECT * FROM `gameserver_mc` WHERE `user_id` = :user_id AND `deleted_at` IS NULL ORDER BY `id` DESC");
                $SQL->execute(array(":user_id" => $userid));
                if ($SQL->rowCount() != 0) {
                    while ($row = $SQL -> fetch(PDO::FETCH_ASSOC)){

                        if($row['state'] == 'active'){
                            $state = '<span class="badge badge-success">Aktiv</span>';
                        } else {
                            $state = '<span class="badge badge-warning">Gesperrt</span>';
                        }

                        if(!is_null($row['locked'])){
                            $state = '<span class="badge badge-warning">Gesperrt</span>';
                        }
                        ?>

                        <div class="col-12 col-xl-3">
                            <div class="card text-center shadow mb-5">
                                <div class="card-header">
                                    <div class="row align-items-center text-center">
                                        <div class="col">
                                            <h3 class="mb-0">
                                                <span class="svg-icon svg-icon-primary svg-icon-8x">
													<i class="fa fa-gamepad" style="color:<?= env('MAIN_COLOR'); ?>;"></i>
												</span>
												<br><br>
                                                    <b>MC</b> #<?= $row['id']; ?>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h4 class="mb-lg-4">
                                                <b>Status</b><br>
                                                <?= $state; ?>
                                            </h4>
                                        </div>
                                    </div>
									
									<hr>
									
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h4 class="mb-0">
                                                <b>Ablaufdatum</b><br>
                                                <?php if($row['state'] == 'PENDING'){ ?>
                                                    <span>Unbekannt</span>
                                                <?php } else { ?>
                                                    <span id="countdown<?= $row['id']; ?>">Lädt...</span>
                                                <?php } ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center text-center">
                                        <div class="col-md-6">
                                            <?php if($row['state'] == 'PENDING'){ ?>
                                                <button disabled="" class="btn btn-block btn-outline-primary">
                                                    <b>Verwalten</b>
                                                </button>
                                            <?php } else { ?>
                                                <a href="<?= env('URL'); ?>manage/gameserver/mc/<?= $row['id']; ?>" class="btn btn-block btn-outline-primary">
                                                    <b>Verwalten</b>
                                                </a>
                                            <?php } ?>
                                        </div>
										
										<br><br><br>
										
                                        <div class="col-md-6">
                                            <?php if($row['state'] == 'PENDING'){ ?>
                                                <button disabled="" class="btn btn-block btn-outline-primary">
                                                    <b>Verlängern</b>
                                                </button>
                                            <?php } else { ?>
                                                <a href="<?= env('URL'); ?>renew/gameserver/mc/<?= $row['id']; ?>" class="btn btn-block btn-outline-primary">
                                                    <b>Verlängern</b>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            var countDownDate<?= $row['id']; ?> = new Date("<?= $row['expire_at']; ?>").getTime();
                            var x<?= $row['id']; ?> = setInterval(function() {

                                var now<?= $row['id']; ?> = new Date().getTime();
                                var distance<?= $row['id']; ?> = countDownDate<?= $row['id']; ?> - now<?= $row['id']; ?>;

                                var days = Math.floor(distance<?= $row['id']; ?> / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance<?= $row['id']; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance<?= $row['id']; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance<?= $row['id']; ?> % (1000 * 60)) / 1000);

                                if(days == 1){ var days_text = ' Tag' } else { var days_text = ' Tage'; }
                                if(hours == 1){ var hours_text = ' Stunde' } else { var hours_text = ' Stunden'; }
                                if(minutes == 1){ var minutes_text = ' Minute' } else { var minutes_text = ' Minuten'; }
                                if(seconds == 1){ var seconds_text = ' Sekunde' } else { var seconds_text = ' Sekunden'; }

                                if(days == 0 && !(hours == 0 && minutes == 0 && seconds == 0)){
                                    $('#countdown<?= $row["id"]; ?>').html(hours+hours_text+', '+  minutes+minutes_text+' und ' +  seconds+seconds_text);
                                    if(days == 0 && hours == 0 && !(minutes == 0 && seconds == 0)){
                                        $('#countdown<?= $row["id"]; ?>').html(minutes+minutes_text+' und '+  seconds+seconds_text);
                                        if(days == 0 && hours == 0 && minutes == 0 && !(seconds == 0)){
                                            $('#countdown<?= $row["id"]; ?>').html(seconds+seconds_text);
                                        }
                                    }
                                } else {
                                    $('#countdown<?= $row["id"]; ?>').html(days+days_text+', '+  hours+hours_text+', '+  minutes+minutes_text+' und '+  seconds+seconds_text);
                                }

                                if (distance<?= $row['id']; ?> <= 0) {
                                    clearInterval(x<?= $row['id']; ?>);
                                }
                            }, 1000);
                        </script>
                    <?php $items++; } } if($items == 0){ ?>

<?php include BASE_PATH.'resources/sites/_errors/produkt_notfound.php' ?>


<?php } ?>
            </div>
        </div>
    </div>
</div>