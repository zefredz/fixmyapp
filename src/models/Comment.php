<?php

class Comment extends Model
{
    public function proposition()
    {
        return $this->belongs_to('Proposition');
    }

    public function author()
    {
        return $this->has_one('User');
    }
}
