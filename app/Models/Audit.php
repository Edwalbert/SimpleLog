<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'user_id', 'event', 'auditable_type', 'auditable_id',
        'old_values', 'new_values', 'url', 'ip_address',
        'user_agent', 'tags',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }

    // Setters
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;
    }

    public function setEventAttribute($value)
    {
        $this->attributes['event'] = $value;
    }

    public function setAuditableTypeAttribute($value)
    {
        $this->attributes['auditable_type'] = $value;
    }

    public function setAuditableIdAttribute($value)
    {
        $this->attributes['auditable_id'] = $value;
    }

    public function setOldValuesAttribute($value)
    {
        $this->attributes['old_values'] = $value;
    }

    public function setNewValuesAttribute($value)
    {
        $this->attributes['new_values'] = $value;
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function setIpAddressAttribute($value)
    {
        $this->attributes['ip_address'] = $value;
    }

    public function setUserAgentAttribute($value)
    {
        $this->attributes['user_agent'] = $value;
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = $value;
    }

    // Getters
    public function getUserIdAttribute()
    {
        return $this->attributes['user_id'];
    }

    public function getEventAttribute()
    {
        return $this->attributes['event'];
    }

    public function getAuditableTypeAttribute()
    {
        return $this->attributes['auditable_type'];
    }

    public function getAuditableIdAttribute()
    {
        return $this->attributes['auditable_id'];
    }

    public function getOldValuesAttribute()
    {
        return $this->attributes['old_values'];
    }

    public function getNewValuesAttribute()
    {
        return $this->attributes['new_values'];
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'];
    }

    public function getIpAddressAttribute()
    {
        return $this->attributes['ip_address'];
    }

    public function getUserAgentAttribute()
    {
        return $this->attributes['user_agent'];
    }

    public function getTagsAttribute()
    {
        return $this->attributes['tags'];
    }
}
