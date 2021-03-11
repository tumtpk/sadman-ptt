<?php 
$rows = 6;
$width = 97/$rows;
?>
<style>
    .hori-timeline .events {
        border-top: 0px solid #e9ecef;
    }
    .events-not-action{
        border-top: 3px solid #E9ECEF;
    }
    .events-action{
        border-top: 3px solid #4090CB;
    }
    .hori-timeline .events .event-list {
        display: block;
        position: relative;
        text-align: center;
        padding-top: 70px;
        margin-right: 0;
    }
    .hori-timeline .events .event-list:before {
        content: "";
        position: absolute;
        height: 36px;
        border-right: 2px dashed #dee2e6;
        top: 0;
    }
    .hori-timeline .events .event-list .event-date {
        position: absolute;
        top: 38px;
        left: 0;
        right: 0;
        width: 75px;
        margin: 0 auto;
        border-radius: 4px;
        padding: 2px 4px;
    }
    @media (min-width: 1140px) {
        .hori-timeline .events .event-list {
            display: inline-block;
            width: <?=$width;?>%;
            padding-top: 45px;
        }
        .hori-timeline .events .event-list .event-date {
            top: -12px;
        }
    }
    .bg-soft-primary {
        background-color: #4090CB !important;
        color: #fff !important;
    }
    .bg-soft-success {
        background-color: #47BD9A !important;
        color: #fff !important;
    }
    .bg-soft {
        background-color: #E9ECEF !important;
        color: #999 !important;
    }
    .card {
        border: none;
        margin-bottom: 24px;
        -webkit-box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
        box-shadow: 0 0 13px 0 rgba(236,236,241,.44);
    }
    .text-muted{
        text-align: left;
        height: 50px;
    }
    .text-events-action{
        color: #4090CB;
    }
    .text-events-not-action{
        color: #E9ECEF;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Horizontal Timeline</h4>

                <div class="hori-timeline" dir="ltr">
                    <ul class="list-inline events">

                        <?php
                        $l = 1;
                         for ($i=0; $i < $rows ; $i++) { 
                            ?>
                        <li class="list-inline-item event-list events-action">
                            <div class="px-4">
                                <div class="event-date bg-soft-primary text-primary"><?=$l;?></div>
                                <h5 class="font-size-16 text-events-action"><?=$l;?></h5>
                                <p class="text-muted">
                                    โพลาไรซ์ไซบอร์ก ไดนามิก แกนีมีด ไคโตซานอะซีโตน เซ็กเตอร์เมตริกซ์ไดออกไซด์ธาลัสซีเมีย
                                </p>
                            </div>
                        </li>
                        <?php $l++; } ?>

                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
