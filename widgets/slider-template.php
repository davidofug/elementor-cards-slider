<?php
function return_slider_template() {
    return '<div class="slide-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
            %s
            </div>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination"></div>
    </div>'
    ;
}
