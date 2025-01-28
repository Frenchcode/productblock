<!-- Block Product Page -->
<div class="product-wrapper">
    <div class="product-container">
        <div class="img-container">
            <a href="{$product_link}" class="naslim-product-img">
                <picture>
                    <img src="{$product_cover_image}" alt="{$product_name}" height="auto" width="560" loading="lazy">
                </picture>
            </a>
            <div class="product-block-text">
                {$product_name}
            </div>
        </div>
        <div class="img-container">
            <a href="{$product_link_two}" class="naslim-product-img">
                <picture>
                    <img src="{$product_cover_image_two}" alt="{$product_name_two}" height="auto" width="560">
                </picture>
            </a>
            <div class="product-block-text">
                {$product_name_two}
            </div>
        </div>
    </div>
</div>
<!-- /Block Product Page -->