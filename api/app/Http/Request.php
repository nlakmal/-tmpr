<?php
namespace Tmpr\Chart\Http;

class Request {
        private $method;
        private $uri;
        private $data;

        public function __construct(array $server) {
            $this->method = $server['REQUEST_METHOD'];
            $this->uri = $server['REQUEST_URI'];
            $this->data = json_decode(file_get_contents('php://input'));
        }

    /**
     * @return mixed
     */
        public function getMethod() {
            return $this->method;
        }

    /**
     * @return mixed
     */
        public function getUri() {
            return $this->uri;
        }

    /**
     * @return mixed
     */
        public function getData() {
            return $this->data;
        }

    /**
     * @param string $method
     * @return bool
     */
        public function isMethod(string $method) {
            return strcasecmp($this->method, $method) === 0;
        }

    /**
     * @param string $action
     * @return bool
     */
        public function isAction(string $action) {
            $regex = '/' . str_replace('\:id', '\d+', preg_quote($action, '/')) . '$/i';
            return preg_match($regex, $this->uri) === 1;
        }

    /**
     * @return mixed
     */
        public function getId() {
            preg_match('/\d+$/', $this->uri, $id);
            return $id[0];
        }
    }
