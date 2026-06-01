<?php

namespace App\Composite;

class File implements FileSystemComponent {
    private string $name;
    private int $size;

    public function __construct(string $name, int $size) {
        $this->name = $name;
        $this->size = $size;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }
}
