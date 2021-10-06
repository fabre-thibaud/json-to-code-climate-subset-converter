<?php

declare(strict_types=1);

namespace BeechIt\JsonToCodeClimateSubsetConverter\PHPMD;

use BeechIt\JsonToCodeClimateSubsetConverter\AbstractConverter;
use BeechIt\JsonToCodeClimateSubsetConverter\Exceptions\InvalidJsonException;
use Phan\Issue;

class PhpMdConvertToSubset extends AbstractConverter
{
    private const SEVERITY_LEVELS = [
        1 => 'major',
        2 => 'major',
        3 => 'minor',
        4 => 'minor',
        5 => 'info'
    ];

    public function convertToSubset(): void
    {
        try {
            $this->abstractJsonValidator->validateJson();

            foreach ($this->json->files as $file) {
                foreach ($file->violations as $node)
                $this->codeClimateNodes[] = [
                    'description' => $this->createDescription($node->description),
                    'fingerprint' => $this->createFingerprint(
                        $node->description,
                        $file->file,
                        $node->beginLine + $node->endLine
                    ),
                    'severity' => self::SEVERITY_LEVELS[$node->priority] ?? 'major',
                    'location' => [
                        'path' => $file->file,
                        'lines' => [
                            'begin' => $node->beginLine,
                            'end' => $node->endLine
                        ],
                    ],
                ];
            }
        } catch (InvalidJsonException $exception) {
            throw $exception;
        }
    }

    public function getToolName(): string
    {
        return 'PHPLint';
    }
}
