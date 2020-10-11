<?php

namespace Knowfox\Core\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Concept extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $base = [
            'id' => $this->id,
            'type' => $this->type,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'body_format' => $this->format,
            'rendered_body' => $this->rendered_body,
            'language' => $this->language,
            'translation_id' => $this->translation_id,
            'parent_id' => $this->parent_id,
            'source_url' => $this->source_url,
            'owner_id' => $this->owner_id,
            'viewed_count' => $this->viewed_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'is_flagged' => $this->is_flagged,
            'slug' => $this->slug,
            'tags' => $this->tags,
            'config' => $this->config,
            'data' => $this->data,
            'rendered_data' => $this->rendered_config,
            'ancestors' => $this->ancestors,
            'attachments' => Attachment::collection($this->attachments),
            'relations' => $this->relations,
            'related' => $this->related,
            'inverse_related' => $this->inverseRelated,
        ];

        if ($this->type != 'concept') {
            $type = $this->type;
            $scoped_type = preg_split('/:\s*/', $this->type, 2);
            if (count($scoped_type) > 1) {
                $package = $scoped_type[0];
                $type = $scoped_type[1];
            }
            $base[$type] = $this->{$type};
        }

        return $base;
    }
}
