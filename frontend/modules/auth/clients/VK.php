<?php

namespace frontend\modules\auth\clients;

use yii\authclient\OAuth2;

class VK extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'http://api.vk.com/oauth/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.vk.com/oauth/access_token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.vk.com/method';


    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('users.get.json', 'GET', [
            'fields' => implode(',', [
                'uid',
                'first_name',
                'last_name',
                'nickname',
                'screen_name',
                'sex',
                'bdate',
                'city',
                'country',
                'timezone',
                'photo'
            ]),
        ]);
        return array_shift($attributes['response']);
    }

    /**
     * @inheritdoc
     */
    protected function apiInternal($accessToken, $url, $method, array $params, array $headers)
    {
        $params['uids'] = $accessToken->getParam('user_id');
        $params['access_token'] = $accessToken->getToken();
        return $this->sendRequest($method, $url, $params, $headers);
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'vkontakte';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'VKontakte';
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'id' => 'uid'
        ];
    }

    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 800,
            'popupHeight' => 500,
        ];
    }
}