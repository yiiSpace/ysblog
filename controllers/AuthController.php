<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/7/27
 * Time: 10:42
 */

namespace app\controllers;

use Yii;

use app\models\LoginForm;
use app\models\User;
use Firebase\JWT\JWT;
use yii\web\Controller;

class AuthController extends Controller
{

    /**
     * @see https://github.com/tecnom1k3/sp-simple-jwt/blob/master/public/login.php
     * @see https://www.sitepoint.com/php-authorization-jwt-json-web-tokens/
     */
    public function actionToken()
    {
        return $this->getToken();
    }

    /**
     * @param User|null $user
     * @return string
     */
    protected function getToken(User $user = null)
    {
        $config = \Yii::$app->params;

        $tokenId = base64_encode(mcrypt_create_iv(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 10;  //Adding 10 seconds
        $expire = $notBefore + 60; // Adding 60 seconds
        $serverName = $config['serverName'];

        /*
         * Create the token as an array
         */
        $data = [
            'iat' => $issuedAt,         // Issued at: time when the token was generated
            'jti' => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss' => $serverName,       // Issuer
            //   'nbf' => $notBefore,        // Not before
            //  'exp' => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                // TODO 登陆的话存下面信息 没登录不用存储
                //  'userId'   => $rs['id'], // userid from the users table
                // 'userName' => $username, // User name
            ]
        ];

        if ($user != null) {
            // user is login
            $data['data'] = [
                'userId' => $user->id,
                'userName' => $user->username,
            ];
        }


        // header('Content-type: application/json');

        /*
         * Extract the key, which is coming from the config file.
         *
         * Best suggestion is the key to be a binary string and
         * store it in encoded in a config file.
         *
         * Can be generated with base64_encode(openssl_random_pseudo_bytes(64));
         *
         * keep it secure! You'll need the exact key to verify the
         * token later.
         */
        $secretKey = base64_decode($config['jwt']['key']);

        /*
         * Extract the algorithm from the config file too
         */
        $algorithm = $config['jwt']['algorithm'];

        /*
         * Encode the array to a JWT string.
         * Second parameter is the key to encode the token.
         *
         * The output string can be validated at http://jwt.io/
         */
        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            $algorithm  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        $unencodedArray = ['jwt' => $jwt];
        return json_encode($unencodedArray);
    }

    protected function decodeToken($jwt)
    {
        $config = Yii::$app->params['jwt'];
        $secretKey = base64_decode($config['key']);

        /*
         * decode the JWT using the key from config
         */
        // $token = JWT::decode($jwt, $secretKey, array('HS512'));
        $token = JWT::decode($jwt, $secretKey, [$config['algorithm']]);

        return $token;
    }

    public function actionTest()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->getUser();
            $jwt = $this->getToken($user);
            \Yii::$app->session->setFlash('jwt', $jwt);
          //  $jwt = json_decode($jwt, true);
           //  print_r($this->decodeToken($jwt['jwt']));
            die($jwt);
            return $this->goBack();
        }
        return $this->render('test', [
            'model' => $model,
        ]);
    }

    public function actionEncrypt()
    {
        $key = 'yiqing' ;
        $data = [
          'name'=>__METHOD__,
        ];
        $data  =  json_encode($data) ;
        $encryptData = Yii::$app->security->encryptByKey($data,$key) ;

        print_r([
            'encryptData'=>$encryptData ,
            'originalData'=>Yii::$app->security->decryptByKey($encryptData,$key) ,
        ]);

        die(__METHOD__) ;

    }
}