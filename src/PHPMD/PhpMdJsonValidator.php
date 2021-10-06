<?php

declare(strict_types=1);

namespace BeechIt\JsonToCodeClimateSubsetConverter\PHPMD;

use BeechIt\JsonToCodeClimateSubsetConverter\AbstractJsonValidator;
use BeechIt\JsonToCodeClimateSubsetConverter\Exceptions\InvalidJsonException;

class PhpMdJsonValidator extends AbstractJsonValidator
{
    public function validateJson(): void
    {
        if (!property_exists($this->json, 'files')) {
            throw new InvalidJsonException('The [files] is a required property');
        }

        foreach ($this->json->files as $node) {
            if (!property_exists($node, 'file')) {
                throw new InvalidJsonException('The [files.file] is a required property');
            }

            if (!property_exists($node, 'violations')) {
                throw new InvalidJsonException('The [files.violations] is a required property');
            }

            foreach ($node->violations as $violation) {
                if (!property_exists($violation, 'description')) {
                    throw new InvalidJsonException('The [files.violations.description] is a required property');
                }

                if (!property_exists($violation, 'beginLine')) {
                    throw new InvalidJsonException('The [files.violations.beginLine] is a required property');
                }

                if (!property_exists($violation, 'endLine')) {
                    throw new InvalidJsonException('The [files.violations.endLine] is a required property');
                }

                if (!property_exists($violation, 'priority')) {
                    throw new InvalidJsonException('The [files.violations.endLine] is a required property');
                }
            }
        }
    }
}
