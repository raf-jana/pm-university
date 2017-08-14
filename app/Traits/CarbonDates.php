<?php

namespace App\Traits\Models;

trait CarbonDates
{
    public function parseCarbonObject($carbonObj)
    {
        return \Carbon\Carbon::parse($carbonObj);
    }

    public function postedAgo(): string
    {
        return $this->parseCarbonObject($this->created_at)
            ->diffForHumans();
    }

    public function postedDate(): string
    {
        return $this->parseCarbonObject($this->created_at)
            ->toDateString();
    }

    public function updatedAgo(): string
    {
        return $this->parseCarbonObject($this->updated_at)
            ->diffForHumans();
    }

    public function deletedAgo(): string
    {
        return $this->parseCarbonObject($this->deleted_at)
            ->diffForHumans();
    }
}