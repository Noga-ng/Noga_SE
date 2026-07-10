<?php

declare(strict_types=1);

namespace Noga\Core;

use RuntimeException;
use JsonException;

final class Config
{
    private const REG_INCLUDE =
        '/@include\(["\'](.+?)["\']\)/';

    private const REG_TYPE =
        '/^(string|int|bool|array|json)\s+(\w+)\s*=\s*([\s\S]*?)(?=^\s*(?:string|int|bool|array|json)\s+\w+\s*=|\z)/m';

    private array $data = [];

    public function __construct(string $file)
    {
        $this->data = $this->load($file);
       
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function all(): array
    {
        return $this->data;
    }

    private function load(string $file): array
    {
        if (!is_file($file)) {
            throw new RuntimeException("Configuration file not found: {$file}");
        }

        $content = file_get_contents($file);

        if ($content === false) {
            throw new RuntimeException("Unable to read {$file}");
        }

        $content = preg_replace('/^\s*#.*$/m', '', $content);

        $content = preg_replace_callback(
            self::REG_INCLUDE,
            function (array $match) use ($file): string {

                $include = dirname($file) . DIRECTORY_SEPARATOR . $match[1];

                if (!is_file($include)) {
                    throw new RuntimeException(
                        "Included file not found: {$include}"
                    );
                }

                return file_get_contents($include);
            },
            $content
        );

        preg_match_all(
            self::REG_TYPE,
            $content,
            $matches,
            PREG_SET_ORDER
        );

        $config = [];

        foreach ($matches as $match) {

            [, $type, $key, $value] = $match;

            if (isset($config[$key])) {
                throw new RuntimeException(
                    "Duplicate configuration key '{$key}'."
                );
            }

            $config[$key] = $this->parse(
                $type,
                trim($value)
            );
        }

        return $config;
    }

    private function parse(string $type, string $value): mixed
    {
        return match ($type) {

            'string' => $this->parseString($value),

            'int' => $this->parseInt($value),

            'bool' => $this->parseBool($value),

            'array' => $this->parseArray($value),

            'json' => $this->parseJson($value),

            default => throw new RuntimeException(
                "Unknown type '{$type}'."
            ),
        };
    }

    private function parseString(string $value): string
    {
        if (!preg_match('/^([\'"]).*\1$/s', $value)) {
            throw new RuntimeException(
                "Invalid string: {$value}"
            );
        }

        return substr($value, 1, -1);
    }

    private function parseInt(string $value): int
    {
        if (!preg_match('/^-?\d+$/', $value)) {
            throw new RuntimeException(
                "Invalid integer: {$value}"
            );
        }

        return (int) $value;
    }

    private function parseBool(string $value): bool
    {
        return match (strtolower($value)) {

            'true' => true,

            'false' => false,

            default => throw new RuntimeException(
                "Invalid boolean: {$value}"
            ),
        };
    }

    private function parseArray(string $value): array
    {
        if (
            !str_starts_with($value, '[')
            || !str_ends_with($value, ']')
        ) {
            throw new RuntimeException(
                'Invalid array syntax.'
            );
        }

        $body = trim(substr($value, 1, -1));

        if ($body === '') {
            return [];
        }

        $lines = array_filter(
            array_map('trim', explode("\n", $body))
        );

        $array = [];

        foreach ($lines as $line) {

            $line = rtrim($line, ',');

            if (!str_contains($line, '=>')) {
                continue;
            }

            [$key, $value] = array_map(
                'trim',
                explode('=>', $line, 2)
            );

            $array[$key] = $this->infer($value);
        }

        return $array;
    }

    private function parseJson(string $value): array
    {
        try {

            return json_decode(
                $value,
                true,
                512,
                JSON_THROW_ON_ERROR
            );

        } catch (JsonException $e) {

            throw new RuntimeException(
                "Invalid JSON.",
                previous: $e
            );
        }
    }

    private function infer(string $value): mixed
    {
        if (preg_match('/^([\'"]).*\1$/', $value)) {
            return substr($value, 1, -1);
        }

        if (strcasecmp($value, 'true') === 0) {
            return true;
        }

        if (strcasecmp($value, 'false') === 0) {
            return false;
        }

        if (strcasecmp($value, 'null') === 0) {
            return null;
        }

        if (preg_match('/^-?\d+$/', $value)) {
            return (int) $value;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return $value;
    }


    /**
 * Export configuration to $_ENV
 */
public function exportEnv(): self
{
    foreach ($this->data as $key => $value) {
        $_ENV[$key] = $value;
    }

    return $this;
}

/**
 * Export configuration to getenv()
 */
public function exportPutenv(): self
{
    foreach ($this->data as $key => $value) {

        if (is_array($value)) {
            continue;
        }

        putenv($key . '=' . $this->normalize($value));
    }

    return $this;
}

/**
 * Export configuration to $GLOBALS
 */
/**
 * Summary of exportGlobals
 * @return static
 */
public function exportGlobals(): static
{
    foreach ($this->data as $key => $value) {
        $GLOBALS[$key] = $value;
    }

    return $this;
}

/**
 * Summary of normalize
 * @param mixed $value
 * @return string
 */
private function normalize(mixed $value): string
{
    return match (true) {

        \is_bool($value)  => $value ? 'true' : 'false',

        \is_null($value)  => '',

        default          => (string) $value,
    };
}

/**
 * Summary of publish
 * @param bool $env
 * @param bool $putenv
 * @param bool $globals
 * @return static
 */
public function loadEnv(bool $env = true,bool $putenv = true,bool $globals = false): static {

    if ($env) {
        $this->exportEnv();
    }

    if ($putenv) {
        $this->exportPutenv();
    }

    if ($globals) {
        $this->exportGlobals();
    }

    return $this;
}

    private function __clone()
    {
    }

    public function __wakeup(): void
    {
        throw new RuntimeException(
            'NgManager cannot be unserialized.'
        );
    }
}