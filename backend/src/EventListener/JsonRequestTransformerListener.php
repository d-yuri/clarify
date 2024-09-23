<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JsonRequestTransformerListener
{
    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }
        if ($this->isJsonRequest($request)) {
            $this->transformJsonBody($request);
        }

    }

    private function isJsonRequest(Request $request) {
        return 'json' === $request->getContentTypeFormat();
    }

    private function transformJsonBody(Request $request) {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return true;
        }
        $request->request->replace($data);
        return true;
    }
}