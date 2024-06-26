<?php

namespace App\Core\Crud\Core;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use App\Helpers\EvaluateClosure;

class TableHeaders
{
    protected array $headers = [];

    public function add(
        string $key,
        null|string|Htmlable|Closure $label = null,
        null|string|Htmlable|Closure $content = null,
        array|Closure $attributes = [],
        array|Closure $classes = [],
        null|string|Closure $component = null,
        null|bool|Closure $sortable = null,
        null|string|Closure $sortableKey = null,
        null|bool|Closure $show = null,
        null|string|Closure $type = 'content',
    ): static {
        $this->headers[$key] = [
            'key' => $key,
            'label' => $label,
            'content' => $content,
            'attributes' => $attributes,
            'classes' => $classes,
            'component' => $component,
            'sortable' => $sortable,
            'sortableKey' => $sortableKey,
            'show' => $show ?? true,
            'type' => $type ?? null,
            // type: 'content', // content|action|actionGroup|empty // WIP
        ];

        return $this;
    }

    public function getHeaders(bool $evaluate = false): array
    {
        return $evaluate ? $this->evaluateHeaders() : $this->headers;
    }

    public function evaluateHeaders(): array
    {
        $result = [];

        foreach ($this->headers as $header) {
            $header['key'] = EvaluateClosure::toString($header['key'] ?? null, $this);
            $header['label'] = EvaluateClosure::toString($header['label'] ?? str($header['key'] ?? null)->toTitle(), $this);
            $header['content'] = EvaluateClosure::toStringOrNull($header['content'] ?? null, $this);
            $header['attributes'] = EvaluateClosure::toArray($header['attributes'] ?? null, $this);
            $header['classes'] = EvaluateClosure::toArray($header['classes'] ?? null, $this);
            $header['component'] = EvaluateClosure::toStringOrNull($header['component'] ?? null, $this);
            $header['sortable'] = EvaluateClosure::toBool($header['sortable'] ?? null, $this);
            $header['sortableKey'] = EvaluateClosure::toStringOrNull($header['sortableKey'] ?? $header['key'] ?? null, $this);
            $header['show'] = EvaluateClosure::toBool($header['show'] ?? true, $this);
            $header['type'] = EvaluateClosure::toStringOrNull($header['type'] ?? null, $this);
            // type: 'content', // content|action|actionGroup|empty // WIP
        }

        return $result;
    }

    public static function make(): static
    {
        return new static();
    }
}
