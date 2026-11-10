<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'subtitle', 'image', 'icon', 'introduction', 'description', 'section', 'url', 'link_label', 'open_in_new_tab', 'sort_order', 'is_active'])]
class Content extends Model
{
    protected function casts(): array
    {
        return [
            'open_in_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
