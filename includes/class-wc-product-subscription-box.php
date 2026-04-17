<?php

class WC_Product_Subscription_Box extends WC_Product {

    protected $extra_data = [
        'billing_period'      => '',
        'billing_interval'    => 1,
        'subscription_length' => '',
        'trial_period'        => 7,
        'max_subscribers'     => 10,
    ];

    public function get_type() {
        return 'subscription_box';
    }

    // -------------------
    // GETTERS
    // -------------------

    public function get_billing_period() {
        return $this->get_prop('billing_period');
    }

    public function get_billing_interval() {
        return $this->get_prop('billing_interval');
    }

    public function get_subscription_length() {
        return $this->get_prop('subscription_length');
    }

    public function get_trial_period() {
        return $this->get_prop('trial_period');
    }

    public function get_max_subscribers() {
        return $this->get_prop('max_subscribers');
    }

    // -------------------
    // SETTERS
    // -------------------

    public function set_billing_period($value) {
        $this->set_prop('billing_period', sanitize_text_field($value));
    }

    public function set_billing_interval($value) {
        $this->set_prop('billing_interval', absint($value));
    }

    public function set_subscription_length($value) {
        $this->set_prop('subscription_length', sanitize_text_field($value));
    }

    public function set_trial_period($value) {
        $this->set_prop('trial_period', absint($value));
    }

    public function set_max_subscribers($value) {
        $this->set_prop('max_subscribers', absint($value));
    }
}
