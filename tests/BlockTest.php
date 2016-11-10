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
}
