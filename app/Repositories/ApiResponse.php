<?php namespace App\Repositories;

use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Support\Facades\Response;

Trait ApiResponse
{

    protected $statusCode = FoundationResponse::HTTP_OK,$header=[];

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * 设置响应头部
     */

    public function getResponseHeader()
    {
        $preArr = array('X-API-TOKEN' => Input::header('X-API-TOKEN'));
        return array_merge($this->header,$preArr);
    }

    /**
     * @param $headerArr
     * @return $this
     */
    public function setResponseHeader(array $headerArr)
    {
        $this->header = $headerArr;
        return $this;
    }

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        return Response::json($data,$this->getStatusCode(),$header);
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data, $code = null){
        if ($code) {
            $this->setStatusCode($code);
        }
        $sta =  array (
            'success' => $status,
            'code'    => $this->statusCode
        );
        $data = array_merge($sta,$data);
        return $this->respond($data,$this->getResponseHeader());
    }

    /**
     * @param $message
     * @param int $code
     * @param string $status
     * @return mixed
     */
    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = false) {
        return $this->setStatusCode($code)
            ->message($message,$status);
    }

    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    public function message($message, $status = true) {
        return $this->status($status,[
            'message' => $message,
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function created($message = "created")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_CREATED)
            ->message($message);
    }

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success($data, $status = true) {
        return $this->status($status,compact('data'),FoundationResponse::HTTP_OK);
    }
}
