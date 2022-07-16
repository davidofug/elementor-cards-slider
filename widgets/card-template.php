<?php
function return_card_template() {
    return '<div class="card swiper-slide">
        <div class="image-content">
            <span class="overlay"></span>
            <div class="card-image">
                <img src="%s" alt="" class="card-img">
            </div>
        </div>
        <div class="card-content">
            <h2 class="name">%s</h2>
            <p class="description">%s</p>

            <button class="button">View More</button>
        </div>
    </div>';

}