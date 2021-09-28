<?php

namespace models;

interface PravilaInterface
{
    public function read();
    public function readSingle();
    public function create();
    public function update();
    public function delete();
}