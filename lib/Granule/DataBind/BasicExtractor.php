<?php
/*
 * MIT License
 *
 * Copyright (c) 2017 Eugene Bogachov
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Granule\DataBind;

abstract class BasicExtractor implements Extractor {
    public function toYAMLString(): string {
        return yaml_emit($this->toSimpleType());
    }

    public function toYAMLFile(string $path): void {
        file_put_contents($path, $this->toYAMLString());
    }

    public function toJSONString(): string {
        return json_encode($this->toSimpleType());
    }

    public function toJSONFile(string $path): void {
        file_put_contents($path, $this->toJSONString());
    }

    public function toXML(): string {
        $xml = new \SimpleXMLElement('<root/>');
        $data = $this->toSimpleType();
        if (is_array($data)) {
            array_walk_recursive($data, [$xml, 'addChild']);
        } else {
            $xml->addChild($data);
        }

        return $xml->asXML();
    }
}