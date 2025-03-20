<?php

declare(strict_types=1);

namespace App\Services\Edid\Base\Section;

use Carbon\Carbon;

/**
 * Represents the base EDID section vendor & product identification
 */
class VendorProductIdentificationSection extends AbstractSection
{
    /**
     * @param  string  $manufacturerName  exactly 3 characters, valid only A-Z
     * @param  string  $productId  exactly 4 hexadecimal characters (a-f, A-F, 0-9)
     * @param  Carbon  $dateForSerialNumber  date used for generating serial number
     * @param  int  $modelYear  must be between 1990 and 2245
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        public readonly string $manufacturerName,
        public readonly string $productId,
        public readonly Carbon $dateForSerialNumber,
        public readonly int $modelYear,
    ) {
        if (preg_match('/^[A-Z]{3}$/', $manufacturerName) !== 1) {
            throw new \InvalidArgumentException('manufacturer name is invalid');
        }

        if (preg_match('/^[a-fA-F0-9]{4}$/', $productId) !== 1) {
            throw new \InvalidArgumentException('product ID is invalid');
        }

        if ($modelYear < 1990 || $modelYear > 2245) {
            throw new \InvalidArgumentException('model year is invalid');
        }
    }

    /**
     * @return array<int>
     */
    public function toBytes(): array
    {
        /** @var array<int> $mergedBytes */
        $mergedBytes = array_merge(
            $this->manufacturerNameToBytes(),
            $this->productIdToBytes(),
            $this->serialNumberToBytes(),
            $this->modelYearToBytes(),
        );

        return $mergedBytes;
    }

    /**
     * Converts upper-case letter from range A-Z to integer, where A=1 and Z=26
     *
     * @return int<1, 26>
     */
    private function upperCaseLetterToFiveBits(string $letter): int
    {
        $number = ord($letter) - ord('A') + 1;
        if ($number < 1) {
            return 1;
        }

        if ($number > 26) {
            return 26;
        }

        return $number;
    }

    /**
     * @return array<int>
     */
    private function manufacturerNameToBytes(): array
    {
        $firstLetterBits = $this->upperCaseLetterToFiveBits($this->manufacturerName[0]);
        $secondLetterBits = $this->upperCaseLetterToFiveBits($this->manufacturerName[1]);
        $thirdLetterBits = $this->upperCaseLetterToFiveBits($this->manufacturerName[2]);

        // 1st bit is 0, 5 bits first letter and 2 bits second letter's most significant bits
        $firstByte = ((0b11111 & $firstLetterBits) << 2) | ((0b11000 & $secondLetterBits) >> 3);
        // first 3 bits are 3 least significant bits from second letter, 5 bits from third letter
        $secondByte = ((0b00111 & $secondLetterBits) << 5) | (0b11111 & $thirdLetterBits);

        return [
            $firstByte,
            $secondByte,
        ];
    }

    /**
     * @return array<int>
     */
    private function productIdToBytes(): array
    {
        // first byte must be least significant byte of product id => last 2 hex characters
        $firstByte = (int) hexdec(substr($this->productId, 2, 2));
        // second byte must be most significant byte of product id => first 2 hex characters
        $secondByte = (int) hexdec(substr($this->productId, 0, 2));

        return [
            $firstByte,
            $secondByte,
        ];
    }

    /**
     * @return array<int>
     */
    private function serialNumberToBytes(): array
    {
        // date format in decimal number: YYMMDDHHmm (two digits per date part - marked by _)
        $dateNumber = ($this->dateForSerialNumber->year % 100) * 1_00_00_00_00
            + $this->dateForSerialNumber->month * 1_00_00_00
            + $this->dateForSerialNumber->day * 1_00_00
            + $this->dateForSerialNumber->hour * 1_00
            + $this->dateForSerialNumber->minute;

        // serial number is saved with least significant byte first
        return [
            $dateNumber & 0b11111111,
            ($dateNumber & 0b11111111_00000000) >> 8,
            ($dateNumber & 0b11111111_00000000_00000000) >> 16,
            ($dateNumber & 0b11111111_00000000_00000000_00000000) >> 24,
        ];
    }

    /**
     * @return array<int>
     */
    private function modelYearToBytes(): array
    {
        return [
            0xFF, // this marks that the next field is model year
            ($this->modelYear - 1990) % 256, // model year is relative to year 1990
        ];
    }
}
