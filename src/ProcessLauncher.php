<?php

namespace Clue\React\Shell;

use React\ChildProcess\Process;
use React\EventLoop\LoopInterface;
use Clue\React\Shell\DeferredShell;
use React\Stream\CompositeStream;

class ProcessLauncher
{
    private $loop;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    /**
     * launch the given interactive $command shell
     *
     * Its STDOUT will be used to parse responses, the STDIN will be used
     * to pass commands.
     *
     * If the command prints output to STDERR, make sure to redirect it to
     * STDOUT by appending " 2>&1".
     *
     * @param string $command
     * @return DeferredShell
     */
    public function createDeferredShell($command)
    {
        $process = new Process($command);
        $process->start($this->loop);

        $stream = new CompositeStream($process->stdout, $process->stdin);

        return new DeferredShell($stream);
    }
}
