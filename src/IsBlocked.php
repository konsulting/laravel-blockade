<?php

namespace Konsulting\Laravel\Blockade;

use Closure;
use Carbon\Carbon;
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

    /**
     * The url to redirect a user to when blocked, optional
     *
     * @var string
     */
    protected $redirect;

    /**
     * Whether we should be checking against a single code, or a comma-delimited list.
     *
     * @var bool
     */
    protected $allowMultipleCodes;

    /**
     * The expiry date for the blockade
     *
     * @var Carbon|null
     */
    protected $until;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;

        $this->key = config('blockade.key', 'dev');
        $this->code = config('blockade.code', false);
        $this->exclude = config('blockade.not_blocked', []);
        $this->redirect = config('blockade.redirect', null);
        $this->until = config('blockade.until', null) ? Carbon::parse(config('blockade.until')) : null;
        $this->allowMultipleCodes = config('blockade.multiple_codes', false);
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

        if ($this->blockHasExpired()) {
            return $next($request);
        }

        if ($request->exists($this->key)) {
            $this->session->put($this->key, $request->input($this->key));

            return redirect($this->urlWithKeyStripped($request));
        }

        if ($this->codeIsValid()) {
            return $next($request);
        }

        if ($this->shouldRedirectWhenBlocked()) {
            return redirect()->away($this->redirect);
        }

        return response(view('blockade::is_blocked'), 200);
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
        $codeToCheck = $this->session->get($this->key, false);

        if ($this->allowMultipleCodes) {
            $referenceCodes = array_map('trim', explode(',', $this->code));

            return in_array($codeToCheck, $referenceCodes, true);
        }

        return $codeToCheck === $this->code;
    }

    /**
     * Has a redirect been provided for use when blocked?
     *
     * @return bool
     */
    protected function shouldRedirectWhenBlocked()
    {
        return null !== $this->redirect;
    }

    /**
     * Check if the block has expired
     */
    protected function blockHasExpired()
    {
        if (! $this->until) {
            return false;
        }

        return $this->until->isPast();
    }
}
