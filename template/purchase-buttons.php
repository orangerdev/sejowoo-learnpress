<div class="sejoli-product-related product-list">
    <!-- <h5 class='title'><?php _e('Kelas ini tersedia pada produk :', 'sejowoo-learnpress'); ?></h5> -->
    <ul>
    <?php
    foreach( (array)$products as $product_id ) :
        $product = get_post( $product_id );
    ?>
        <li>
            <a href='<?php echo wc_get_cart_url()."?add-to-cart=$product_id"; ?>'>
                <?php echo __('Add to Cart', 'sejowoo-learnpress'); ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
