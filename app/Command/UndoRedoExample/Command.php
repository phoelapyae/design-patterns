<?php

namespace App\Command\UndoRedoExample;

interface Command {
    public function execute();
    public function undo();
}
