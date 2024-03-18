<?php

declare(strict_types=1);

namespace App\Token\Shared\Domain;

use App\Token\Handlers\Exceptions\FileNotFoundException;

abstract class RSAKey
{
    /**
     * @param string $path
     * @param string $filename
     */
    protected function __construct(
        protected readonly string $path,
        protected readonly string $filename,
    ) {
    }

    /**
     * @return bool
     */
    public function isExist(): bool
    {
        return file_exists($this->fullPath());
    }

    /**
     * @return string
     */
    public function fullPath(): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->filename;
    }

    /**
     * @return string
     */
    public function read(): string
    {
        if (!$this->isExist()) {
            throw FileNotFoundException::new($this->fullPath());
        }

        return file_get_contents($this->fullPath());
    }
}
