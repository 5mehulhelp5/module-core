<?php

namespace Commerce365\Core\Service\Request;

interface PostInterface
{
    /**
     * @param $method
     * @param array $postData
     * @return array
     */
    public function execute($method, array $postData = []): array;
}
