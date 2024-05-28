<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Fluent;
use App\Libs\RenderHelpers\CustomBladeRender;

class CustomInlineBlade extends Component
{
    public ?CustomBladeRender $customBladeRender = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $view,
        Fluent|array $data,
    ) {
        $this->customBladeRender = CustomBladeRender::make(
            CustomBladeRender::viewContentFromPath($view),
            $data,
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return $this->customBladeRender?->render();
    }
}
