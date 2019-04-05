<?php

namespace Konsulting\Laravel\Blockade;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store as SessionStore;

class IsBlocked
{
    /** @var SessionStore */
    protected $session;

    /**
     * The blockade pass code.
     *
     * @var string
     */
    protected $code;

    /**
     * The URL parameter through which the blockade code may be supplied.
     *
     * @var string
     */
    protected $key;

    /**
     * The list of URLs to exclude from the block.
     *
     * @var string[]
     */
    protected $exclude;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;

        $this->key = config('blockade.key', 'dev');
        $this->code = config('blockade.code', false);
        $this->exclude = config('blockade.not_blocked', []);
    }

    /**
     * Check if we should proceed to the route, or display the blocked view.
     *
     * @param Request $request
     * @param Closure $next
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

        if (! $this->codeIsValid()) {
            return response(view('blockade::is_blocked'), 200);
        }

        return $next($request);
    }

    /**
     * Check if the current route is excluded from the block.
     *
     * @param Request $request
     * @return bool
     */
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

    /**
     * Get the current URL with the blockade key parameter removed.
     *
     * @param Request $request
     * @return string
     */
    protected function urlWithKeyStripped($request)
    {
        $query = $request->except($this->key);

        return $request->path() . ($query ? '?' . http_build_query($query) : '');
    }

    /**
     * Check if the supplied code is valid.
     *
     * @return bool
     */
    protected function codeIsValid()
    {
        $referenceCodes = array_map('trim', explode(',', $this->code));
        $codeToCheck = $this->session->get($this->key, false);

        return in_array($codeToCheck, $referenceCodes, true);
    }
}
