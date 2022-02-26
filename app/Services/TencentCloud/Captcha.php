<?php

namespace App\Services\TencentCloud;

use Max\Config\Annotations\Config;
use Max\Di\Annotations\Inject;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use TencentCloud\Captcha\V20190722\CaptchaClient;
use TencentCloud\Captcha\V20190722\Models\DescribeCaptchaResultRequest;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;

class Captcha
{
    /**
     * @var ServerRequestInterface
     */
    #[Inject]
    protected ServerRequestInterface $request;

    #[Inject]
    protected LoggerInterface $logger;

    /**
     * @var string
     */
    #[Config(key: 'qcloud.captcha.secret_key')]
    protected string $secretKey;
    /**
     * @var string
     */
    #[Config(key: 'qcloud.captcha.app_id')]
    protected string $appId;

    #[Inject]
    protected User $user;

    /**
     * @param $ticket
     * @param $randStr
     *
     * @return bool
     */
    public function valid($ticket, $randStr): bool
    {
        try {
            $cred        = new Credential($this->user->getSecretId(), $this->user->getSecretKey());
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("captcha.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new CaptchaClient($cred, "", $clientProfile);
            $req    = new DescribeCaptchaResultRequest();
            $params = [
                'CaptchaType'  => 9,
                'Ticket'       => $ticket,
                'UserIp'       => $this->request->ip(),
                'Randstr'      => $randStr,
                'CaptchaAppId' => (int)$this->appId,
                'AppSecretKey' => $this->secretKey,
            ];
            $req->fromJsonString(json_encode($params));
            $resp = $client->DescribeCaptchaResult($req);

            return 1 === $resp->getCaptchaCode();
        } catch (TencentCloudSDKException $e) {
            $this->logger->debug('验证码请求失败: ' . $e->getMessage(), $e->getTrace());
            return false;
        }
    }

}
