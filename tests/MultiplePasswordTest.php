<?php

namespace Konsulting\Laravel\Blockade;

class MultiplePasswordTest extends BlockingTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('blockade.code', 'pass1, pass2');
    }

    /** @dataProvider passwordProvider */
    public function test_it_accepts_multiple_passwords($password, $shouldPass)
    {
        $this->visitRoute('home', ['dev' => $password]);

        $method = $shouldPass ? 'see' : 'dontSee';
        $this->$method('Home');
    }

    public function passwordProvider()
    {
        return [
            ['pass1', true],
            ['pass2', true],
            [' pass2 ', true],
            ['pass1, pass2', false],
        ];
    }
}
