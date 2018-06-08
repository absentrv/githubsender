<?php

namespace frontend\libraries;



/**
 * Description of GithubLib
 *
 * @author Serhii Filoniuk
 */
class GithubLib
{
    private $apiUrl = 'https://api.github.com/users/';    
    private $client;
    private $token = '432fa6bab54184c7da97a7061218fed7887866c0';
    
    
    public function __construct(\yii\base\Component $client)
    {
        $this->client = $client;
    }
    
    public function getUserInfo(string $username)
    {        
        $response = $this->client->createRequest()
            ->setMethod('get')            
            ->setHeaders([
                'User-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36',
                'Authorization' => 'Bearer '. $this->token
                ])
            ->setUrl($this->apiUrl . $username)
            ->send();       
        if($response->isOk) {
            return json_decode($response->content);
        }
        return false;
    }
}
