<?php

/**
 * PAris model to represent a user
 */
class User extends Model 
{
    public function propositions()
    {
        return $this->has_many('Proposition');
    }

    public function comments()
    {
        return $this->has_many('Comment');
    }
}
