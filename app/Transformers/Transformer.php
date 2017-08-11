<?php

namespace App\Transformers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Transformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = [];
    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Getter for availableIncludes.
     *
     * @return array
     */
    public function getAvailableIncludes()
    {
        return $this->availableIncludes;
    }

    /**
     * Getter for defaultIncludes.
     *
     * @return array
     */
    public function getDefaultIncludes()
    {
        return $this->defaultIncludes;
    }

    /**
     * Get Include Method.
     *
     * @param $includeName
     * @return string
     */
    protected function getIncludeMethod($includeName)
    {
        // Check if the method name actually exists
        return 'include' . str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('-', ' ', $includeName))));
    }

    protected function getIncludeData($parentData)
    {
        $manager = new Manager();
        $includes = $_GET['include'];
        $includeData = [];
        $thisManager = ($manager->parseIncludes($includes));
        $requestedIncludes = $thisManager->getRequestedIncludes();
        foreach ($requestedIncludes as $requestedInclude) {
            $includeMethod = $this->getIncludeMethod($requestedInclude);
            if (method_exists($this, $includeMethod)) {
                $includeData[$requestedInclude] = $this->{$includeMethod}($parentData, $thisManager->getIncludeParams($requestedInclude));
            }
        }
        return $includeData;
    }

    /**
     * Validate optional params
     *
     * @param $validParams
     * @param ParamBag|null $params
     * @throws \Exception
     */
    protected function validateOptionalParams($validParams, ParamBag $params = null)
    {
        $usedParams = array_keys(iterator_to_array($params));
        if ($invalidParams = array_diff($usedParams, $validParams)) {
            throw new \Exception(sprintf(
                'Invalid param(s): "%s". Valid param(s): "%s"', implode(',', $usedParams), implode(',', validParams)
            ));
        }
    }

    public function transformCollection(array $items, $function = 'transform')
    {
        return array_map([$this, $function], $items);
    }

    public function transformPaginator(LengthAwarePaginator $paginator, $data)
    {
        return [
            'meta' => [
                'paginator' => [
                    'total' => $paginator->total(),
                    'totalPages' => ceil($paginator->total() / $paginator->perPage()),
                    'currentPage' => $paginator->currentPage(),
                    'lastPage' => $paginator->lastPage(),
                    'links' => [
                        'nextPageUrl' => $paginator->nextPageUrl() ?? '',
                        'prevPageUrl' => $paginator->previousPageUrl() ?? '',
                    ],
                    'perPage' => $paginator->perPage(),
                    'hasMore' => $paginator->hasMorePages()
                ],
            ],
            'data' => $data
        ];
    }

    public abstract function transform($item);
}