<div class="end-side">
    <div class="endfloor">
        <div class="shop" style="width: 100%;height: 3200px;">
            <div class="clockArea">
                <div class="digtal-clock">NEXUS MALL
                    <!-- <span class="num-slot" id="t0">0</span>
                    <span class="num-slot" id="t1">0</span>
                    <span class="divider">:</span>
                    <span class="num-slot" id="t2">0</span>
                    <span class="num-slot" id="t3">0</span>
                    <span class="divider">:</span>
                    <span class="num-slot" id="t4">0</span>
                    <span class="num-slot" id="t5">0</span> -->
                </div>
            </div>
            <?php
            //秀出active
            function activeShow($num, $chkPoint)
            {
                return (($num == $chkPoint) ? "active" : "");
            }
            //廣告輪播
            $SQLstring = "SELECT * FROM carousel WHERE caro_online=1 ORDER BY caro_sort";
            $carousel = $link->query($SQLstring);
            $i = 0;
            ?>
            <div class="carousel-wrapper">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php for ($i = 0; $i < $carousel->rowCount(); $i++) { ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i; ?>"
                                class="<?php echo activeShow($i, 0); ?>" aria-current="true" aria-label="Slide <?php echo $i; ?>"></button>
                        <?php } ?>
                    </div>
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        while ($data = $carousel->fetch()) {
                        ?>
                            <div class="carousel-item <?php echo activeShow($i, 0) ?>">
                                <div onclick="showShopDetail(<?php echo $data['p_id']; ?>)" style="z-index:10; cursor:pointer;"><img src="<?php echo $data['caro_pic']; ?>" class="d-block w-100" alt=""></a></div>
                            </div>
                        <?php $i++;
                        } ?>
                    </div>

                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>