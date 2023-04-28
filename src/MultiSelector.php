<?php

namespace Kostasmatrix\MultiSelector;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class MultiSelector extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'multi-selector';

    public function weup($resource)
    {
        return $this->withMeta(['resourcer' => $resource]);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            // Add any additional data your Vue component may require
        ]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request,
                                                $requestAttribute,
                                                $model,
                                                $attribute)
    {
        dump("I mean... are we ven filling or what?");
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = 'booyakashsha';
        }
    }
}
