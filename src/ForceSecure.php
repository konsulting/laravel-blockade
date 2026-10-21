<?php

namespace Konsulting\Laravel\Blockade;

use Closure;

class ForceSecure
{
    protected $exclude;

    public function __construct()
    {
        $this->exclude = config('blockade.not_secure', []);
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
        if (! $request->secure() && $this->shouldBeSecured($request)) {
            // A request for "//evil.com/" would otherwise redirect off-site to "//evil.com/".
            $path = preg_replace('#^/+#', '/', $request->getRequestUri());

            return redirect()->secure($path);
        }

        return $next($request);
    }

    protected function shouldBeSecured($request)
    {
        foreach ($this->exclude as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }

        return true;
    }
}
