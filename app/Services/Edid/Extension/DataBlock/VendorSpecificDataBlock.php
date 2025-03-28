<?php

declare(strict_types=1);

namespace App\Services\Edid\Extension\DataBlock;

class VendorSpecificDataBlock extends AbstractDataBlock
{
    /**
     * @param  array<int>  $data
     */
    public function __construct(
        public readonly string $vendorId,
        public readonly array $data
    ) {
        if (preg_match('/^[a-fA-F0-9]{6}$/', $vendorId) !== 1) {
            throw new \InvalidArgumentException('product ID is invalid');
        }

        if (count($data) !== count(array_filter($this->data, fn (int $item) => $item >= 0 && $item <= 255))) {
            throw new \InvalidArgumentException('data are invalid');
        }

        // max data length is 28 - 31 bytes for payload (5 bits for length in vendor block header) - 3 bytes for vendor ID
        if (count($data) > 28) {
            throw new \InvalidArgumentException('data are too long');
        }
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        return array_merge(
            $this->headerToBytes(),
            $this->vendorIdToBytes(),
            $this->data,
        );
    }

    /**
     * @return array<int>
     */
    private function headerToBytes(): array
    {
        // 3 bytes for vendor ID + length of data
        $payloadLength = 3 + count($this->data);

        // bits 7-5 represents CTA data block tag code = 0x03, bits 4-0 represents length of the payload following the header
        return [
            0b01100000 | $payloadLength,
        ];
    }

    /**
     * @return array<int>
     */
    private function vendorIdToBytes(): array
    {
        // first byte must be least significant byte of vendor id => last 2 hex characters
        $firstByte = (int) hexdec(substr($this->vendorId, 4, 2));
        // second byte must be second least significant byte of vendor id => second 2 hex characters
        $secondByte = (int) hexdec(substr($this->vendorId, 2, 2));
        // third byte must be most significant byte of vendor id => first 2 hex characters
        $thirdByte = (int) hexdec(substr($this->vendorId, 0, 2));

        return [
            $firstByte,
            $secondByte,
            $thirdByte,
        ];
    }
}
