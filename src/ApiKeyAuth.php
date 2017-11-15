<?php

namespace cloudpdf\filters;

/**
 * Authentikálás a requestben szereplő api kulcs használatával.
 *
 * @author Tamas Szekeres <szektam2@gmail.com>
 * @version 1.0
 * @since 1.0
 */
class ApiKeyAuth extends \yii\filters\auth\AuthMethod
{
    /**
     * @var string
     */
    public $userClass;

    /**
     * Nem sikerült az azonosítás
     *
     * @inheritdoc
     */
    public function challenge($response)
    {
        // pl. kimenet formázásának beállítása + fejléc mezők beállítása
        $response->headers->add('X-Api-Status', 'error');
        $response->headers->add('X-Api-Message', 'Authentication fail!');
        $response->headers->add('X-Api-Code', '8755');
    }

    /**
     * alap UnauthorizedHttpException felülírása
     *
     * @inheritdoc
     */
    public function handleFailure($response) {
        $response->data = [
            'success' => false,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response)
    {
        $this->user = $this->userClass::findByApiKey($request->get('apiKey'));
        return $this->user;
    }
}
