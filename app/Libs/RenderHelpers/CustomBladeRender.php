<?php

namespace App\Libs\RenderHelpers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Fluent;

class CustomBladeRender
{
    public ?string $viewContent = null;
    public ?Fluent $cdata = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $view,
        Fluent|array $data = [],
    ) {
        $this->setViewContent($view);
        $this->setCdata($data);
    }

    public function getParamData(): array
    {
        return [
            'cdata' => fn (?string $key = null, mixed $default = null): mixed => $this->cdata($key, $default),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return \Illuminate\Support\Facades\Blade::render($this->getViewContent(), $this->getParamData());
    }

    public function cdata(?string $key = null, mixed $default = null): mixed
    {
        if (!is_null($key) && !filled($key)) {
            return null;
        }

        if (is_null($key)) {
            return $this->getCdata();
        }

        if (preg_match('/[\ \-\_]|^([1-9])/', $key)) {
            return $this->getCdata()->get(
                str($key)->camel()?->toString(),
                $this->getCdata()->get($key, $default),
            );
        }

        return $this->getCdata()->get($key, $default);
    }

    public function setViewContent(string $viewContent): static
    {
        $this->viewContent = $viewContent;

        return $this;
    }

    public function getViewContent(): string
    {
        return $this->viewContent ?? '';
    }

    public function getCdata(): Fluent
    {
        return $this->cdata ?? fluent([]);
    }

    public function setCdata(Fluent|array $data): static
    {
        $data = is_array($data) ? collect($data)
            ->filter(fn ($item, $key) => is_string($key) && !is_numeric($key) && !is_numeric(substr($key, 0, 1)))
                ?->mapWithKeys(function ($value, $key) {
                    $result = [
                        $key => $value,
                    ];

                    if (preg_match('/[\ \-\_]/', $key)) {
                        $result[str($key)->camel()->toString()] = $value;
                    }

                    return $result;
                })?->toArray() : $data;

        $this->cdata = is_array($data) ? fluent($data) : $data;

        return $this;
    }

    public static function make(
        string $view,
        Fluent|array $data = [],
    ): static {
        return new static($view, $data, );
    }

    public static function inlineRender(
        string $view,
        Fluent|array $data = [],
    ): static {
        return new static($view, $data, );
    }

    public static function viewContentFromPath(string $viewPath): string
    {
        $content = file_get_contents(
            resource_path(
                collect([
                    'views',
                    ...explode('.', $viewPath),
                ])
                        ?->filter(fn ($item) => filled($item))
                        ?->map(fn ($item) => trim($item, '/\\'))
                        ?->implode('/') . '.blade.php'
            )
        );

        return $content ?: '';
    }
}
