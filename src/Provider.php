<?php

namespace Hellkid\SocialiteNaszaklasa;

use GuzzleHttp\Exception\BadResponseException;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;
use Hellkid\SocialiteNaszaklasa\Support\OAuthConsumer;
use Hellkid\SocialiteNaszaklasa\Support\OAuthUtil;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'NASZAKLASA';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'BASIC_PROFILE_ROLE',
        'EMAIL_PROFILE_ROLE'
    ];

    protected $fields = [
        'id',
        'name',
        'emails',
        'displayName',
        'currentLocation',
        'gender',
        'hasApp',
        'photos',
        'profileUrl',
        'thumbnailUrl',
        'urls',
        'age',
        'nkFriendsCount',
        'phoneNumbers'
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://nk.pl/oauth2/login', $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://nk.pl/oauth2/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $url = 'http://opensocial.nk-net.pl/v09/social/rest/people/@me';

        $params = [
            'nk_token' => $token,
            'fields' => implode(',', $this->fields),
        ];

        $consumer = new OAuthConsumer($this->clientId, $this->clientSecret);

        $headers = OAuthUtil::prepareHeaders($consumer, $url, $params);

        $url = $url . "?" . OAuthUtil::build_http_query($params);

        $response = json_decode($this->getHttpClient()->get($url, [
            'headers' => $headers,
        ])->getBody(), true);

        if (!isset( $response['entry'] ) || !isset( $response['entry']['id'] ) || isset( $response['error'] ) ){
            throw new BadResponseException( "User profile request failed! Request to {$url} returned an invalid response.", 6 );
        }

        return $response['entry'];

    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['id'],
            'name'     => $user['name']['formatted'],
            'nickname' => $user['name']['formatted'],
            'email'    => $user['emails'][0]['value'],
            'avatar'   => $user['photos'][1]['value'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }

}
