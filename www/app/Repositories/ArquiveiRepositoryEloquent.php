<?php

namespace App\Repositories;

use App\Repositories\ArquiveiRepositoryInterface;
use App\Repositories\NfesRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use App\Events\Worker;

class ArquiveiRepositoryEloquent implements ArquiveiRepositoryInterface
{

    protected $nfe;
    protected $client;

    const ENDPOINT_NFE_RECEIVED = 'https://sandbox-api.arquivei.com.br/v1/nfe/received';

    public function __construct(NfesRepositoryInterface $nfesRepositoryInterface)
    {

        $this->nfe = $nfesRepositoryInterface;
        $this->setClient();
    }

    public function setClient()
    {
        $this->client = new \GuzzleHttp\Client(['headers' => array(
            'Content-Type' => 'application/json',
            'x-api-id' => 'f96ae22f7c5d74fa4d78e764563d52811570588e',
            'x-api-key' => 'cc79ee9464257c9e1901703e04ac9f86b0f387c2'
        )]);
    }

    /**
     * Parse Total Value in XML.
     *
     * @param $xml
     *
     * @return string
     */
    public function getPriceOnXml(string $xml)
    {
        $NfeXml = base64_decode($xml);
        $NfeXml = simplexml_load_string($NfeXml);

        if (isset($NfeXml->infNFe->total->ICMSTot->vNF)) {

            return ((string) $NfeXml->infNFe->total->ICMSTot->vNF);
        }

        return ((string) $NfeXml->NFe->infNFe->total->ICMSTot->vNF);
    }

    /**
     * Find all Nfes.
     *
     * @param $status
     * @param $urlCursor
     *
     * @return mixed
     */
    public function get(string $status, string $urlCursor = null)
    {

        if ($urlCursor) {

            $responseSandbox = $this->client->request('GET', $urlCursor);
        } else if ($status === 'received') {

            $responseSandbox = $this->client->request('GET', self::ENDPOINT_NFE_RECEIVED);
        } else {

            throw new Exception('implementation error');
        }

        $headers = $responseSandbox->getHeaders();

        if ($headers['X-RateLimit-Remaining'][0] == '0') {
            return 'rate_limit_reached';
        }

        $responseSandbox = $responseSandbox->getBody()->getContents();

        return json_decode($responseSandbox);
    }

    /**
     * Find a nfe by access key.
     *
     * @param $access
     *
     * @return mixed
     */
    public function findByAccessKey(string $access_key, Request $request)
    {
        $nfe = $this->nfe->getByAccessKey($access_key);

        if ($nfe->count() > 0) {

            if (isset($request->showNfe) && $request->showNfe == 'true') {

                $nfe[0]['xml_content'] = base64_decode($nfe[0]['xml_content']);
            } else if (isset($request->showBase64Nfe) && $request->showBase64Nfe == 'true') {

                $nfe = $nfe;
            } else {
                unset($nfe[0]['xml_content']);
            }


            return $nfe;
        }

        $responseSandbox = $this->client->request(
            'GET',
            self::ENDPOINT_NFE_RECEIVED . '?access_key[]=' . $access_key,
            [
                'http_errors' => false
            ]
        );

        $responseSandbox = $responseSandbox->getBody()->getContents();
        $content = json_decode($responseSandbox);

        if (isset($content->errors)) {
            return null;
        }

        $content = $content->data[0];

        $parsedContent = new \stdClass();
        $parsedContent->xml_content = $content->xml;
        $parsedContent->access_key = $content->access_key;
        $parsedContent->total_value = $this->getPriceOnXml($content->xml);

        event(new Worker($parsedContent));
    }
}
