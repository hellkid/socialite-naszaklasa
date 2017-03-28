# Nasza Klasa (http://nk.pl) OAuth2 Provider for Laravel Socialite

[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/SocialiteProviders/NaszaKlasa.svg?style=flat-square)](https://scrutinizer-ci.com/g/SocialiteProviders/NaszaKlasa/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/socialiteproviders/naszaklasa.svg?style=flat-square)](https://packagist.org/packages/socialiteproviders/naszaklasa)
[![Total Downloads](https://img.shields.io/packagist/dt/socialiteproviders/naszaklasa.svg?style=flat-square)](https://packagist.org/packages/socialiteproviders/naszaklasa)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/socialiteproviders/naszaklasa.svg?style=flat-square)](https://packagist.org/packages/socialiteproviders/naszaklasa)
[![License](https://img.shields.io/packagist/l/socialiteproviders/naszaklasa.svg?style=flat-square)](https://packagist.org/packages/socialiteproviders/naszaklasa)

## Documentation
This package is based on awesome packages by [Socialite Providers](http://socialiteproviders.github.io/) 

You can always refer to their docs if you need more info on how to use this package.
## INSTALLATION

### 1. COMPOSER

This assumes that you have composer installed globally

```composer require hellkid/socialite-naszaklasa```
### 2. SERVICE PROVIDER

Remove ```Laravel\Socialite\SocialiteServiceProvider``` from your ```providers[]``` array in ```config\app.php``` if you have added it already.

Add ```\SocialiteProviders\Manager\ServiceProvider::class``` to your ```providers[]``` array in ```config\app.php```.

For example:
```
'providers' => [
    // a whole bunch of providers
    // remove 'Laravel\Socialite\SocialiteServiceProvider',
    \SocialiteProviders\Manager\ServiceProvider::class, // add
];
```
Note: If you would like to use the Socialite Facade, you need to [!install](https://laravel.com/docs/5.0/authentication#social-authentication) it.
### 3. ADD THE EVENT AND LISTENERS

Add ```SocialiteProviders\Manager\SocialiteWasCalled``` event to your ```listen[]``` array in  ```<app_name>/Providers/EventServiceProvider```.

Add your listeners (i.e. the ones from the providers) to the  ```SocialiteProviders\Manager\SocialiteWasCalled[]``` that you just created.

The listener that you add for this provider is  ```'Hellkid\Hellkid\SocialiteNaszaklasa\NaszaKlasaExtendSocialite@handle'```,.

Note: You do not need to add anything for the built-in socialite providers unless you override them with your own providers.

For example:
```
/**
 * The event handler mappings for the application.
 *
 * @var array
 */
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // add your listeners (aka providers) here
        'Hellkid\Hellkid\SocialiteNaszaklasa\NaszaKlasaExtendSocialite@handle',
    ],
];
```
### 4. ENVIRONMENT VARIABLES

If you add environment values to your .env as exactly shown below, you do not need to add an entry to the services array.

APPEND PROVIDER VALUES TO YOUR ```.ENV``` FILE
```
// other values above
NASZAKLASA_KEY=yourkeyfortheservice
NASZAKLASA_SECRET=yoursecretfortheservice
NASZAKLASA_REDIRECT_URI=https://example.com/login   
```
ADD TO CONFIG/SERVICES.PHP.

You do not need to add this if you add the values to the .env exactly as shown above. The values below are provided as a convenience in the case that a developer is not able to use the .env method
```
'naszaklasa' => [
    'client_id' => env('NASZAKLASA_KEY'),
    'client_secret' => env('NASZAKLASA_SECRET'),
    'redirect' => env('NASZAKLASA_REDIRECT_URI'),  
], 
```
You should now be able to use it like you would regularly use Socialite (assuming you have the facade installed):
```
return Socialite::with('naszaklasa')->redirect();
```

You can use Socialite providers with Lumen. Just make sure that you have facade support turned on and that you follow the setup directions properly.

Note: If you are using this with Lumen, all providers will automatically be stateless since Lumen does not keep track of state.

Also, configs cannot be parsed from the ```services[]``` in Lumen. You can only set the values in the .env file as shown exactly in this document. If needed, you can also override a config.

