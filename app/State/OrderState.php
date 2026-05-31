<?php

namespace App\State;

interface OrderState {
    public function cancelOrder(Context $context);

    public function confirmOrder(Context $context);

    public function payOrder(Context $context);

    public function shipOrder(Context $context);

    public function getStatus(): string;
}
