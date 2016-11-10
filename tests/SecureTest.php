<?php

namespace Konsulting\Laravel\Blockade;

class SecureTest extends SecuringTestCase
{
    public function test_it_redirects_a_secure_route()
    {
        $this->visit('http://localhost/secure')
            ->assertEquals('https://localhost/secure', $this->currentUri);
    }

    public function test_it_doesnt_redirect_an_insecure_route()
    {
        $this->visitRoute('not-secure')
            ->see('Not Secure')
            ->assertEquals('http://localhost/not-secure', $this->currentUri);
    }
}
