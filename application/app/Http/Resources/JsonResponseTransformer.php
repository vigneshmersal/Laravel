<?php

namespace App\Libraries;

class JsonResponseTransformer
{

    public static function create($key, $paginator, $identifiers)
    {

        $in = $paginator->toArray();

        //get 'data' property into "out" array and then remove it
        $out[$key] = $in['data'];
        unset($in['data']);

        //set links object
        $out['links'] = [
            'self' => $paginator->url($paginator->currentPage()),
            'first' => $paginator->url(1),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
            'last' => $paginator->url($paginator->lastPage())
        ];

        //set meta object
        $out['meta'] = [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => 1,
            'to' => $paginator->lastPage()
        ];

        return array_merge($identifiers, $out);
    }
}
