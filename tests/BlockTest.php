<?php

namespace Konsulting\Laravel\Blockade;

class BlockTest extends BlockingTestCase
{
    public function test_it_blocks_access_to_home()
    {
        $this->visitRoute('home')
            ->dontSee('Home');
    }

    public function test_it_doesnt_block_home_with_the_right_code()
    {
        $this->visitRoute('home', ['dev' => 'abc'])
            ->see('Home');
    }

    public function test_it_doesnt_block_access_to_a_non_blocked_route()
    {
        $this->visitRoute('not-blocked')
            ->see('Not Blocked');
    }

    /** @dataProvider passwordProvider */
    public function test_it_accepts_multiple_codes($code, $shouldPass, $enableMultipleCodes = true)
    {
        $this->app['config']->set('blockade.code', 'pass1, pass 2');
        $this->app['config']->set('blockade.multiple_codes', $enableMultipleCodes);
        $this->visitRoute('home', ['dev' => $code]);

        $method = $shouldPass ? 'see' : 'dontSee';
        $this->$method('Home');
    }

    public function passwordProvider()
    {
        return [
            ['pass1', true],
            ['pass 2', true],
            [' pass 2 ', true],
            ['pass1, pass 2', false],
            ['pass1, pass 2', true, false],
            ['pass1', false, false],
        ];
    }
}
