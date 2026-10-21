<?php

namespace Konsulting\Laravel\Blockade;

class SecureTest extends SecuringTestCase
{
    public function test_it_redirects_a_secure_route()
    {
        $this->visit('http://localhost/secure')
            ->assertEquals('https://localhost/secure', $this->currentUri);
    }

    public function test_it_keeps_the_query_string()
    {
        $this->call('GET', 'http://localhost/secure?a=1&b=2');

        $this->assertEquals('https://localhost/secure?a=1&b=2', $this->response->headers->get('Location'));
    }

    /**
     * @dataProvider offSitePaths
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('offSitePaths')]
    public function test_it_never_redirects_off_site($path, $expected)
    {
        $this->call('GET', 'http://localhost'.$path);

        $this->assertEquals($expected, $this->response->headers->get('Location'));
    }

    public static function offSitePaths()
    {
        return [
            'double slash' => ['//evil.com/', 'https://localhost/evil.com'],
            'triple slash' => ['///evil.com/x', 'https://localhost/evil.com/x'],
        ];
    }

    public function test_it_doesnt_redirect_an_insecure_route()
    {
        $this->visitRoute('not-secure')
            ->see('Not Secure')
            ->assertEquals('http://localhost/not-secure', $this->currentUri);
    }
}
