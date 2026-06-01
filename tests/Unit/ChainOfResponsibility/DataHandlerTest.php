<?php

use App\ChainOfResponsibility\DataHandler;
use App\ChainOfResponsibility\HttpHandler;
use App\ChainOfResponsibility\Main;

test('it processes data and passes the request to the next handler', function () {
    $nextHandler = new class extends HttpHandler
    {
        public bool $handled = false;

        public function handle($request)
        {
            $this->handled = true;

            return true;
        }
    };

    $handler = new DataHandler;
    $handler->setNext($nextHandler);

    ob_start();

    try {
        $result = $handler->handle([
            'is_logged_in' => true,
            'clicks_per_minute' => 30,
        ]);
    } finally {
        $output = ob_get_clean();
    }

    expect($result)->toBeTrue()
        ->and($nextHandler->handled)->toBeTrue()
        ->and($output)->toBe('Data processing completed.'.PHP_EOL);
});

test('the example chain runs through the data handler', function () {
    ob_start();

    try {
        (new Main)->run();
    } finally {
        $output = ob_get_clean();
    }

    expect($output)->toBe('Data processing completed.'.PHP_EOL);
});
