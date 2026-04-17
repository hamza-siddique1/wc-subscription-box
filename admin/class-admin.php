<?php

add_filter('woocommerce_product_data_tabs', function ($tabs) {

    $tabs['subscription_box_options'] = [
        'label'  => 'Subscription Options',
        'target' => 'subscription_box_options_data',
        'class'  => ['show_if_subscription_box'],
    ];

    return $tabs;
});

add_action('woocommerce_product_data_panels', function () {

    global $product;

    ?>
    <div id="subscription_box_options_data" class="panel woocommerce_options_panel">
        <?php

        woocommerce_wp_select([
            'id' => '_billing_period',
            'label' => 'Billing Period',
            'options' => [
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
                'yearly' => 'Yearly',
            ],
            'value' => $product->get_billing_period()
        ]);

        woocommerce_wp_text_input([
            'id' => '_billing_interval',
            'label' => 'Billing Interval',
            'type' => 'number',
            'value' => 5
        ]);

        woocommerce_wp_select([
            'id' => '_subscription_length',
            'label' => 'Subscription Length',
            'options' => [
                '1_month' => '1 Month',
                '3_months' => '3 Months',
                '6_months' => '6 Months',
                'ongoing' => 'Ongoing',
            ],
            'value' => '1_month'
        ]);

        woocommerce_wp_text_input([
            'id' => '_trial_period',
            'label' => 'Trial Period (days)',
            'type' => 'number',
            'value' => 7
        ]);

        woocommerce_wp_text_input([
            'id' => '_max_subscribers',
            'label' => 'Max Subscribers',
            'type' => 'number',
            'value' => 10
        ]);

        ?>
    </div>
    <?php
});

add_action('woocommerce_process_product_meta', function ($post_id) {

    $product = wc_get_product($post_id);

    if ($product->get_type() !== 'subscription_box') return;

    if (isset($_POST['_billing_period'])) {
        $product->set_billing_period($_POST['_billing_period']);
    }

    if (isset($_POST['_billing_interval'])) {
        $product->set_billing_interval($_POST['_billing_interval']);
    }

    if (isset($_POST['_subscription_length'])) {
        $product->set_subscription_length($_POST['_subscription_length']);
    }

    if (isset($_POST['_trial_period'])) {
        $product->set_trial_period($_POST['_trial_period']);
    }

    if (isset($_POST['_max_subscribers'])) {
        $product->set_max_subscribers($_POST['_max_subscribers']);
    }

    $product->save();
});

add_action('woocommerce_single_product_summary', function () {

    global $product;

    if ($product->get_type() !== 'subscription_box') return;

    echo '<div class="subscription-box-summary">';
    echo 'Billed every ' . $product->get_meta('_billing_interval') . ' ';
    echo $product->get_meta('_billing_period');
    echo '</div>';

}, 25);

add_filter('woocommerce_product_single_add_to_cart_text', function ($text, $product) {
    if ($product->get_type() === 'subscription_box') {
        return 'Subscribe Now';
    }
    return $text;
}, 10, 2);

add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {

    $product = $cart_item['data'];

    if ($product->get_type() !== 'subscription_box') return $item_data;

    $item_data[] = [
        'name' => 'Billing',
        'value' => $product->get_meta('_billing_period')
    ];

    return $item_data;
}, 10, 2);

add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values) {

    $product = $values['data'];

    if ($product->get_type() !== 'subscription_box') return;

    $item->add_meta_data('Billing Period', $product->get_meta('_billing_period'));

}, 10, 3);
