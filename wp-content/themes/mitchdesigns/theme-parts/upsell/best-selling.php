<?php
if (wp_is_mobile()) {
  $number_of_products = 4;
} else {
  $number_of_products = 8;
}
?>
<div class="section_best">

  <div class="product home">
    <div class="product_container">
      <?php $best_selling_ids = mitch_get_best_selling_products_ids($number_of_products);  ?>
      <ul class="products_list <?php if ($number_of_products >= 5) {
                                  echo 'slider_widget';
                                } else {
                                  echo 'no_slider';
                                } ?>">
        <?php
        if (!empty($best_selling_ids)) {
          foreach ($best_selling_ids as $product_id) {
            if ($product_id == 1730 || $product_id == 3065) {
              continue;
            }
            $product_data = mitch_get_short_product_data($product_id);
            include get_template_directory() . '/theme-parts/product-widget.php';
          }
        } ?>
      </ul>
    </div>
  </div>
</div>