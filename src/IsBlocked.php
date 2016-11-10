<?php

namespace Konsulting\Laravel\Blockade;

use Closure;
use Illuminate\Session\Store;

class IsBlocked
{
    protected $session;
    protected $code;
    protected $key;
    protected $exclude;

    public function __construct(Store $session)
    {
        $this->session = $session;

        $this->key = config('blockade.key', 'dev');
        $this->code = config('blockade.code', false);
        $this->exclude = config('blockade.not_blocked', []);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isExcludedFromBlock($request)) {
            return $next($request);
        }

        if ($request->exists($this->key)) {
            $this->session->put($this->key, $request->input($this->key));

            return redirect($this->urlWithKeyStripped($request));
        }

        if ($this->session->get($this->key, false) !== $this->code) {
            return response(view('blockade::is_blocked'), 200);
        }

        return $next($request);
    }

    protected function isExcludedFromBlock($request)
    {
        if ($this->code == false) {
            return true;
        }

        foreach ($this->exclude as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }

    protected function urlWithKeyStripped($request)
    {
        $query = $request->except($this->key);

        return $request->path() . ($query ? '?' . http_build_query($query) : '');
    }
}
