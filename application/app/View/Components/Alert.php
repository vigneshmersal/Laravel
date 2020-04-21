<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * The alert type.
     *
     * @var string
     */
    public $alertType;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($alertType, $message)
    {
        $this->alertType = $alertType;
        $this->message = $message;
    }

    /**
     * Component Methods
     * public methods on the component may also be executed
     * @param  string  $option
     * @return bool
     */
    public function isSelected($option) // $isSelected($value)
    {
        return $option === $this->selected;
    }
    public function size() // @size
    {
        return 'Large';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');

        # Inline Component Blade Views -> php artisan make:component Alert --inline
        return <<<'blade'
            <div class="alert alert-danger">
                {{ $slot }}
            </div>
        blade;
    }
}
