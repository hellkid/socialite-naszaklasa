<?php

namespace Hellkid\SocialiteNaszaklasa;

use SocialiteProviders\Manager\SocialiteWasCalled;

class NaszaKlasaExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('naszaklasa', __NAMESPACE__.'\Provider');
    }
}
