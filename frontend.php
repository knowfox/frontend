<?php

use Knowfox\Core\Models\Concept;

return [
    'concept' => [
        'package' => 'core',
        'layout' => 'core::' . config('crud.theme') . '.layouts.app',
        'has_create' => true,
        'home_route' => 'concept.index',
        'model' => Concept::class,
        'order_by' => 'title',
        'entity_name' => 'concept',
        'entity_title' => [' Concept', 'Concepts'],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
        ],

        'fields' => [
            'is_flagged' => [
                'label' => 'Flagged',
                'type' => 'checkbox',
            ],
            'parent_id' => [
                'label' => 'Parent',
                'width' => '1-2',
                'type' => 'ref',
                'url' => '/concepts',
            ],
            'type' => [
                'label' => 'Type',
                'width' => '1-2',
            ],
            'title' => [
                'label' => 'Title',
            ],
            'summary' => [
                'label' => 'Summary',
                'type' => 'textarea',
            ],
            'body' => [
                'label' => 'body',
                'type' => 'markdown',
            ],
            'data' => [
                'label' => 'Data',
                'type' => 'textarea',
            ],
            'source_url' => [
                'label' => 'Source URL',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'status' => [
                'label' => "Status",
                'width' => '1-2',
                'type' => 'select',
                'option_values' => ['private', 'public'],
            ],
            'todoist_id' => [
                'label' => 'Todoist-ID',
                'width' => '1-2',
            ],
        ]
    ],
];
