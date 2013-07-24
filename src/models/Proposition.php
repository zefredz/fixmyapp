<?php

class Proposition extends Model
{
    public function comments()
    {
        return $this->has_many('Comment');
    }

    public function author()
    {
        return $this->has_one('User');
    }
}
