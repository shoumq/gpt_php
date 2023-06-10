<?php
namespace gpt_php\mypackage;

class GPT_CLIENT
{
    protected $gpt_token;
    protected $setText;

    public function __construct($gpt_token)
    {
        $this->gpt_token = $gpt_token;
    }

    public function getAnswer($setText)
    {
        $data = array(
            "model" => "gpt-3.5-turbo",
            "prompt" => $setText,
            "temperature" => 0.7,
            "max_tokens" => 2048,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            "stop" => [
                "Human:",
                "AI:"
            ]
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pawan.krd/v1/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $this->gpt_token . '';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($response, true)['choices'][0]['text'];
    }
}
