<?php

declare(strict_types=1);

use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\get;

// test('asserts true is true', function () {
//     $this->assertTrue(true);

//     dd("Usma");

//     expect(true)->toBeTrue();
// });

// it('has home', function () {
//     get('/')->assertStatus(200);

//     // Same as:
//     $this->get('/')->assertStatus(200);
// });


it('receives a HTTP OK on the home page', function() {
    get(
        uri: route('home')
        )->assertStatus(
            Http::OK
        );
});
