<?php

namespace Idiorm\Bdal;

/**
 *
 * Idiorm
 *
 * http://github.com/zefredz/idiorm/
 *
 * A single-class super-simple database abstraction layer for PHP.
 * Provides (nearly) zero-configuration object-relational mapping
 * and a fluent interface for building basic, commonly-used queries.
 *
 * BSD Licensed.
 *
 * Original Idiorm code Copyright (c) 2010, Jamie Matthews
 * Idiorm for Dbal Copyright (c) 2013, Frédéric Minne
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * A result set class for working with collections of model instances
 * @author Simon Holywell <treffynnon@php.net>
 */
class ResultSet implements \Countable, \IteratorAggregate, \ArrayAccess, \Serializable {
    /**
     * The current result set as an array
     * @var array
     */
    protected $_results = array();

    /**
     * Optionally set the contents of the result set by passing in array
     * @param array $results
     */
    public function __construct(array $results = array()) {
        $this->set_results($results);
    }

    /**
     * Set the contents of the result set by passing in array
     * @param array $results
     */
    public function set_results(array $results) {
        $this->_results = $results;
    }

    /**
     * Get the current result set as an array
     * @return array
     */
    public function get_results() {
        return $this->_results;
    }

    /**
     * Get the current result set as an array
     * @return array
     */
    public function as_array() {
        return $this->get_results();
    }
    
    /**
     * Get the number of records in the result set
     * @return int
     */
    public function count() {
        return count($this->_results);
    }

    /**
     * Get an iterator for this object. In this case it supports foreaching
     * over the result set.
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator($this->_results);
    }

    /**
     * ArrayAccess
     * @param int|string $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->_results[$offset]);
    }

    /**
     * ArrayAccess
     * @param int|string $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return $this->_results[$offset];
    }
    
    /**
     * ArrayAccess
     * @param int|string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        $this->_results[$offset] = $value;
    }

    /**
     * ArrayAccess
     * @param int|string $offset
     */
    public function offsetUnset($offset) {
        unset($this->_results[$offset]);
    }

    /**
     * Serializable
     * @return string
     */
    public function serialize() {
        return serialize($this->_results);
    }

    /**
     * Serializable
     * @param string $serialized
     * @return array
     */
    public function unserialize($serialized) {
        return unserialize($serialized);
    }

    /**
     * Call a method on all models in a result set. This allows for method
     * chaining such as setting a property on all models in a result set or
     * any other batch operation across models.
     * @example ORM::for_table('Widget')->find_many()->set('field', 'value')->save();
     * @param string $method
     * @param array $params
     * @return \Idiorm\Dbal\ResultSet
     */
    public function __call($method, $params = array()) {
        foreach($this->_results as $model) {
            call_user_func_array(array($model, $method), $params);
        }
        return $this;
    }
}

