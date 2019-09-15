<?php


namespace App\Compiler\Avro;


use App\Util\Utils;

trait HasName
{

    /** @var string */
    public $name;

    /** @var string|null */
    public $namespace;

    /** @var string */
    public $phpNamespace;

    public function getCompilePath(): string {
        $namespace = preg_replace("/\\\/", DIRECTORY_SEPARATOR, $this->phpNamespace);
        return Utils::joinPaths($namespace, $this->name.'.php');
    }

    public function getQualifiedPhpType(): string {
        return ltrim($this->phpNamespace . '\\' . $this->name, '\\');
    }

    protected function configurePhpNamespace() {
        $parts = preg_split('/\./', $this->namespace);
        $newParts = array_map(function (string $p) {
            return ucfirst($p);
        }, $parts);
        $this->phpNamespace = join('\\', $newParts);
    }

}