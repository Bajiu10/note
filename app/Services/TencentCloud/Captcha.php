<?php

namespace App\Services\TencentCloud;

use Max\Http\Exceptions\HttpException;
use Psr\Http\Message\ServerRequestInterface;

class Captcha
{
//    #[Inject]
//    protected LoggerInterface $logger;
//
//    /**
//     * @var string
//     */
//    #[Config(key: 'services.qcloud.captcha.secret_key')]
//    protected string $secretKey;
//    /**
//     * @var string
//     */
//    #[Config(key: 'services.qcloud.captcha.app_id')]
//    protected string $appId;
//
//    #[Inject]
//    protected User $user;

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     * @throws HttpException
     */
    public function valid(ServerRequestInterface $request): bool
    {
        if (1 === $this->check_ticket($request->input('ticket'), $request->input('randstr'))) {
            return true;
        }
        return false;
//        try {
//            $cred        = new Credential($this->user->getSecretId(), $this->user->getSecretKey());
//            $httpProfile = new HttpProfile();
//            $httpProfile->setEndpoint("captcha.tencentcloudapi.com");
//
//            $clientProfile = new ClientProfile();
//            $clientProfile->setHttpProfile($httpProfile);
//            $client = new CaptchaClient($cred, "", $clientProfile);
//            $req    = new DescribeCaptchaResultRequest();
//            $params = [
//                'CaptchaType'  => 9,
//                'Ticket'       => $request->input('ticket'),
//                'UserIp'       => $request->ip(),
//                'Randstr'      => $request->input('randstr'),
//                'CaptchaAppId' => (int)$this->appId,
//                'AppSecretKey' => $this->secretKey,
//            ];
//            $req->fromJsonString(json_encode($params));
//            $resp = $client->DescribeCaptchaResult($req);
//
//            return 1 === $resp->getCaptchaCode();
//        } catch (TencentCloudSDKException $e) {
//            $this->logger->debug('验证码请求失败: ' . $e->getMessage(), $e->getTrace());
//            return false;
//        }
    }

    protected function check_ticket($ticket, $randstr)
    {
        $url = 'https://cgi.urlsec.qq.com/index.php?m=check&a=gw_check&callback=url_query&url=https%3A%2F%2Fwww.qq.com%2F' . rand(111111, 999999) . '&ticket=' . urlencode($ticket) . '&randstr=' . urlencode($randstr);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $httpheader[] = "Accept: application/json";
        $httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
        $httpheader[] = "Connection: close";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        curl_setopt($ch, CURLOPT_REFERER, 'https://urlsec.qq.com/check.html');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);

        $arr = $this->jsonp_decode($ret, true);
        if (isset($arr['reCode']) && $arr['reCode'] == 0) { //验证通过
            return 1;
        } elseif ($arr['reCode'] == -109) { //验证码错误
            return 0;
        } else { //接口已失效
            return -1;
        }
    }

    protected function jsonp_decode($jsonp, $assoc = false)
    {
        $jsonp = trim($jsonp);
        if (isset($jsonp[0]) && $jsonp[0] !== '[' && $jsonp[0] !== '{') {
            $begin = strpos($jsonp, '(');
            if (false !== $begin) {
                $end = strrpos($jsonp, ')');
                if (false !== $end) {
                    $jsonp = substr($jsonp, $begin + 1, $end - $begin - 1);
                }
            }
        }
        return json_decode($jsonp, $assoc);
    }
}
