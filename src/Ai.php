<?php

namespace Ai;

use Ai\Base\AipBase;

class Ai
{
    //配置
    protected $config;
    //client
    protected $client;
    //默认路径
    protected $endPoint = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/product/';
    //图片参数
    protected $params;
    //其它参数
    protected $options;
    //api 类型
    protected $type = [
        //相同图检索
        'same'    => 'https://aip.baidubce.com/rest/2.0/realtime_search/same_hq/',
        //相似图检索
        'similar' => 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/similar/',
        //商品检索
        'product' => 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/product/',
    ];
    //方法类型
    protected $whereType = [
        //入库
        'add',
        //检索
        'search',
        //删除
        'delete',
        //更新
        'update',
    ];

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new AipBase($this->config['appId'], $this->config['apiKey'], $this->config['secretKey']);
    }

    /**
     * 调用图片为 image文件 或 url
     * @param $image
     * @return $this
     */
    public function select($image)
    {
        $this->params = $image;

        return $this;
    }

    /**
     * 附加参数
     * @param $options
     * @return $this
     */
    public function options($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * 判断imgae 是文件或者 url 并请求返回结果
     * @param  null  $limit
     * @return array
     */
    public function get($limit = null)
    {
        if (!preg_match("/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is", $this->params)) {
            $data['image'] = base64_encode(file_get_contents($this->params));

        } else {
            $data['url'] = $this->params;
        }
        $data = array_merge($data, $this->options);

        $images = $this->client->post($this->endPoint, $data);

        if ($this->search != 'search') {
            return $images;
        }

        if (empty($images['result'])) {
            return [];
        }
        $images_collect = collect($images['result']);
        if ($limit) {
            $images_collect->splice($limit);
        }

        return $images_collect->toArray();
    }

    /**
     *
     * @param  string  $param   指定调用的接口
     * @param  string  $type    指定调用的方法类型
     * @return $this
     * @throws \Exception
     */
    public function where($param = 'product', $type = 'search')
    {
        if (!array_key_exists($param, $this->config['type'])) {
            throw new \Exception('invalid argument:'.$param);
        }
        if (!in_array($type, $this->whereType)) {
            throw new \Exception('invalid argument:'.$type);
        }
        $this->search = $type;
        $this->endPoint = $this->config['type'][$param].$type;

        return $this;
    }
}
